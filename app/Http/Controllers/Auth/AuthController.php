<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.initialization-password');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'statut' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'login.required' => 'Le nom d\'utilisateur est obligatoire.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'statut.required' => 'Le statut dans l\'association est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $login = trim($validated['login']);
        $email = mb_strtolower(trim($validated['email']));

        $user = User::where('login', $login)
            ->where('email', $email)
            ->where('actif', true)
            ->first();

        if (! $user) {
            return $this->throwInitializationFailed();
        }

        // Autorisé seulement si compte non initialisé OU réactivé récemment
        $isNeverInitialized = is_null($user->password) || $user->password === '';
        $isReactivation = $user->reactivation_approved_at
            && $user->reactivation_approved_at->gt(now()->subDay());

        if (! $isNeverInitialized && ! $isReactivation) {
            return $this->throwInitializationFailed();
        }

        $user->update([
            'statut' => $validated['statut'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => null,
        ]);

        if ($isReactivation) {
            $user->update([
                'reactivation_requested_at' => null,
                'reactivation_requested_by' => null,
                'reactivation_approved_at' => null,
                'reactivation_approved_by' => null,
            ]);
        }

        event(new Registered($user));

        $message = $isReactivation
            ? 'Votre compte a été réinitialisé avec succès ! Un e-mail de vérification vous a été envoyé.'
            : 'Le compte a bien été initialisé. Un e-mail de vérification vous a été envoyé.';

        return redirect()->route('email.verification.waiting')->with('status', $message);
    }

    private function throwInitializationFailed(): never
    {
        throw ValidationException::withMessages([
            'login' => 'Impossible d\'initialiser ce compte avec les informations fournies.',
        ]);
    }
}
