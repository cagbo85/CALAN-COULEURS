<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function disable(Request $request, $id)
    {
        $current = Auth::user();
        $user = User::findOrFail($id);

        if ($current->role === 'super-admin') {
            if ($user->id === $current->id) {
                notify()->error("Tu ne peux pas te désactiver toi-même.", 'Modification échouée ! ❌');
                return back()->withInput();
            }
        } elseif ($current->role === 'admin') {
            if ($user->role !== 'editor') {
                notify()->error("Tu ne peux désactiver que les comptes avec le rôle 'editor'.", 'Modification échouée ! ❌');
                return back()->withInput();
            }
        } else {
            notify()->error("Tu n'as pas la permission de désactiver des comptes.", 'Modification échouée ! ❌');
            return back()->withInput();
        }

        $user->actif = 0;
        $user->updated_by = $current->id;
        $user->reactivation_requested_at = null;
        $user->reactivation_requested_by = null;
        $user->reactivation_approved_at = null;
        $user->reactivation_approved_by = null;
        $user->save();

        notify()->success("Le compte de {$user->email} a été désactivé avec succès.", 'Modification réussie ! 🎉');

        return back()->withInput();
    }

    public function requestReactivation(Request $request, $id)
    {
        $current = Auth::user();
        $user = User::findOrFail($id);

        if ($user->actif) {
            notify()->error("Le compte est déjà actif.", 'Demande échouée ! ❌');
            return back()->withInput();
        }

        if ($user->reactivation_requested_at) {
            notify()->error("Une demande de réactivation est déjà en cours.", 'Demande échouée ! ❌');
            return back()->withInput();
        }

        if ($current->role === 'admin' && $user->role === 'editor') {
            $user->reactivation_requested_at = now();
            $user->reactivation_requested_by = $current->id;
            $user->save();

            notify()->success("Demande de réactivation envoyée à l'administrateur.", 'Demande réussie ! 🎉');
            return back()->withInput();
        } else {
            notify()->error("Tu n'as pas le droit de demander la réactivation de ce compte.", 'Demande échouée ! ❌');
            return back()->withInput();
        }
    }

    public function reactivate(Request $request, $id)
    {
        $current = Auth::user();
        $user = User::findOrFail($id);

        if ($current->role !== 'super-admin') {
            notify()->error("Tu n'as pas la permission de réactiver des comptes.", 'Réactivation échouée ! ❌');
            return back()->withInput();
        }

        if ($user->actif) {
            notify()->error("Ce compte est déjà actif.", 'Réactivation échouée ! ❌');
            return back()->withInput();
        }

        if ($user->id === $current->id) {
            notify()->error("Tu ne peux pas te réactiver toi-même.", 'Réactivation échouée ! ❌');
            return back()->withInput();
        }

        // Réactivation directe
        $user->actif = 1;
        $user->email_verified_at = null;
        $user->password = Hash::make(Str::random(60) . time());
        $user->remember_token = null;
        $user->reactivation_requested_at = null;
        $user->reactivation_requested_by = null;
        $user->reactivation_approved_at = now();
        $user->reactivation_approved_by = $current->id;
        $user->save();

        notify()->success("Utilisateur réactivé avec succès.", 'Réactivation réussie ! 🎉');
        return back()->withInput();
    }

    public function approveReactivation(Request $request, $id)
    {
        $current = Auth::user();
        $user = User::findOrFail($id);

        if ($current->role !== 'super-admin') {
            notify()->error("Tu n'as pas la permission d'approuver les réactivations.", 'Approbation échouée ! ❌');
            return back()->withInput();
        }

        if ($user->actif) {
            notify()->error("Ce compte est déjà actif.", 'Approbation échouée ! ❌');
            return back()->withInput();
        }

        if (!$user->reactivation_requested_at) {
            notify()->error("Aucune demande de réactivation en cours.", 'Approbation échouée ! ❌');
            return back()->withInput();
        }

        $user->actif = 1;
        $user->email_verified_at = null;
        $user->password = Hash::make(Str::random(60) . time());
        $user->remember_token = null;
        $user->reactivation_approved_at = now();
        $user->reactivation_approved_by = $current->id;
        $user->save();

        notify()->success("Réactivation approuvée avec succès.", 'Approbation réussie ! 🎉');
        return back()->withInput();
    }
}
