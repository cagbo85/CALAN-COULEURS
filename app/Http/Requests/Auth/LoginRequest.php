<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login_field = filter_var($this->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
        $this->merge([$login_field => $this->input('login')]);

        $credentials = [
            $login_field => $this->input('login'),
            'password' => $this->input('password'),
        ];

        $user = User::where($login_field, $this->input('login'))->first();

        if (! $user) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'login' => 'Ces identifiants ne correspondent à aucun compte.',
            ]);
        }

        // Vérifier que l'utilisateur est actif
        if (! $user->actif) {
            throw ValidationException::withMessages([
                'login' => 'Votre compte a été désactivé. Contactez un administrateur.',
            ]);
        }

        if ($this->hasTemporaryPassword($user)) {
            // Rediriger vers la page d'initialisation avec un message
            session()->flash('reactivation_notice', true);
            session()->flash('login_for_init', $this->input('login'));

            throw ValidationException::withMessages([
                'login' => 'Votre compte a été réactivé. Vous devez réinitialiser votre mot de passe.',
            ])->redirectTo(route('password.initialize'));
        }

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'login' => 'Mot de passe incorrect.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => 'Trop de tentatives de connexion. Réessayez dans ' . ceil($seconds / 60) . ' minutes.',
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('login')) . '|' . $this->ip());
    }

    /**
     * Vérifier si l'utilisateur a un mot de passe temporaire
     */
    private function hasTemporaryPassword($user): bool
    {
        // Si password est null, c'est un compte pas encore initialisé
        if (is_null($user->password)) {
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
