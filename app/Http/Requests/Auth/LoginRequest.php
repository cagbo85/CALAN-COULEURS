<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginInput = (string) $this->input('login');
        $loginField = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';

        $credentials = [
            $loginField => $loginInput,
            'password' => $this->input('password'),
            'actif' => 1,
        ];

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            $this->throwInvalidCredentials();
        }

        $user = Auth::user();

        if (! $user) {
            // Cas de sécurité défensif
            Auth::logout();
            $this->throwInvalidCredentials();
        }

        // On ne révèle l'état "compte réactivé" qu'après auth réussie
        if ($this->hasTemporaryPassword($user)) {
            Auth::logout();

            session()->flash('reactivation_notice', true);
            session()->flash('login_for_init', $loginInput);

            throw ValidationException::withMessages([
                'login' => 'Votre compte a été réactivé. Vous devez réinitialiser votre mot de passe.',
            ])->redirectTo(route('password.initialize'));
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Retourne une erreur d'authentification générique.
     *
     * @throws ValidationException
     */
    private function throwInvalidCredentials(): never
    {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => 'Identifiants invalides.',
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => 'Trop de tentatives de connexion. Réessayez dans '.ceil($seconds / 60).' minutes.',
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('login')).'|'.$this->ip());
    }

    /**
     * Vérifier si l'utilisateur a un mot de passe temporaire
     */
    private function hasTemporaryPassword($user): bool
    {
        // Si password est null ou vide, c'est un compte pas encore initialisé
        if (is_null($user->password) || $user->password === '') {
            return false;
        }

        // Si le compte a été réactivé récemment (dans les dernières 24h)
        // et que reactivation_approved_at existe
        if (
            $user->reactivation_approved_at &&
            $user->reactivation_approved_at->gt(now()->subDay())
        ) {
            return true;
        }

        return false;
    }
}
