<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\VerifyEmailNotification;

/**
 * Class User
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $login
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string $statut
 * @property bool $actif
 * @property string|null $remember_token
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|Artiste[] $artistes
 * @property Collection|Faq[] $faqs
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'actif' => 'bool',
        'updated_by' => 'int'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'firstname',
        'lastname',
        'login',
        'email',
        'email_verified_at',
        'password',
        'role',
        'statut',
        'actif',
        'remember_token',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function artistes()
    {
        return $this->hasMany(Artiste::class, 'updated_by');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'updated_by');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'updated_by');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super-admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isActive(): bool
    {
        return $this->actif;
    }

    public function canCreateUsers(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canDeactivateUser(User $targetUser): bool
    {
        // Super-admin peut désactiver n'importe qui
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Admin peut désactiver seulement les editors
        if ($this->isAdmin()) {
            return $targetUser->isEditor();
        }

        // Editor ne peut désactiver personne
        return false;
    }

    public function canEditUser(User $targetUser): bool
    {
        // Super-admin peut tout éditer
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Admin peut éditer les editors
        if ($this->isAdmin()) {
            return $targetUser->isEditor();
        }

        // Editor peut seulement s'éditer lui-même
        return $this->id === $targetUser->id;
    }

    public function canDeleteUser(User $targetUser): bool
    {
        // Seul super-admin peut supprimer, et pas lui-même
        return $this->isSuperAdmin() && $this->id !== $targetUser->id;
    }

    /**
     * Envoyer la notification de vérification d'email personnalisée
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }
}
