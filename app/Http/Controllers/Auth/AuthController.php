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

        // 2. Vérifier que l'utilisateur existe en BDD avec ce login
        $user = User::where('login', $validated['login'])->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'login' => 'Les informations d\'identification ne sont pas valides ou l\'initialisation de votre compte a déjà été effectuée.',
            ]);
        }

        // 3. Vérifier que l'email n'est pas déjà utilisé par un autre utilisateur
        $existingEmailUser = User::where('email', $validated['email'])
            ->where('id', '!=', $user->id)
            ->first();

        if ($existingEmailUser) {
            throw ValidationException::withMessages([
                'email' => 'Cette adresse e-mail est déjà utilisée par un autre compte.',
            ]);
        }

        // 4. Mettre à jour les informations de l'utilisateur
        $user->update([
            'email' => $validated['email'],
            'statut' => $validated['statut'],
            'password' => Hash::make($validated['password']),
            'actif' => true, // Activer le compte
        ]);

        event(new Registered($user));

        // 5. Rediriger vers la page de vérification d'email
        // return redirect()->route('verification.notice')->with(
        //     'status',
        //     'Votre compte a été initialisé avec succès ! Veuillez vérifier votre adresse e-mail pour finaliser l\'activation.'
        // );

        return redirect()->route('email.verification.waiting')->with('status', 'Le compte a bien été initialisé. Un e-mail de vérification vous a été envoyé.');
    }
}
