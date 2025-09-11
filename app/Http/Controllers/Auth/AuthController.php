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
        // 1. Validation des données du formulaire
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

        // 2. Vérifier que l'utilisateur existe
        $user = User::where('login', $validated['login'])->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'login' => 'Les informations d\'identification ne sont pas valides.',
            ]);
        }

        // 3. Vérifier que le compte est actif
        if (!$user->actif) {
            throw ValidationException::withMessages([
                'login' => 'Votre compte est désactivé. Contactez un administrateur.',
            ]);
        }

        // 4. Vérifier les conditions d'initialisation
        $canInitialize = false;
        $isReactivation = false;

        // Compte jamais initialisé (password = null)
        if (is_null($user->password)) {
            $canInitialize = true;
        }
        // Compte réactivé récemment
        elseif (
            $user->reactivation_approved_at &&
            $user->reactivation_approved_at->gt(now()->subDay())
        ) {
            $canInitialize = true;
            $isReactivation = true;
        }

        if (!$canInitialize) {
            throw ValidationException::withMessages([
                'login' => 'L\'initialisation de votre compte a déjà été effectuée. Utilisez la page de connexion normale.',
            ]);
        }

        // 5. Vérifier que l'email n'est pas déjà utilisé par un autre utilisateur
        $existingEmailUser = User::where('email', $validated['email'])
            ->where('id', '!=', $user->id)
            ->first();

        if ($existingEmailUser) {
            throw ValidationException::withMessages([
                'email' => 'Cette adresse e-mail est déjà utilisée par un autre compte.',
            ]);
        }

        // 6. Mettre à jour les informations de l'utilisateur
        $user->update([
            'email' => $validated['email'],
            'statut' => $validated['statut'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => null,  // Force la vérification email
        ]);

        // 7. Si c'était une réactivation, nettoyer les champs de réactivation
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
}
