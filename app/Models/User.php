<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
 * @property Carbon|null $reactivation_requested_at
 * @property int|null $reactivation_requested_by
 * @property Carbon|null $reactivation_approved_at
 * @property int|null $reactivation_approved_by
 * @property string|null $remember_token
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|Artiste[] $artistes
 * @property Collection|Faq[] $faqs
 * @property Collection|OrderItem[] $order_items
 * @property Collection|Order[] $orders
 * @property Collection|Partenaire[] $partenaires
 * @property Collection|Product[] $products
 * @property Collection|ProductsVariant[] $products_variants
 * @property Collection|Stand[] $stands
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
        'reactivation_requested_at' => 'datetime',
        'reactivation_requested_by' => 'int',
        'reactivation_approved_at' => 'datetime',
        'reactivation_approved_by' => 'int',
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
        'reactivation_requested_at',
        'reactivation_requested_by',
        'reactivation_approved_at',
        'reactivation_approved_by',
        'remember_token',
        'updated_by'
    ];

    /**
     * Utilisateur ayant demandé la réactivation (self-relation).
     */
    public function reactivationRequestedBy()
    {
        return $this->belongsTo(User::class, 'reactivation_requested_by');
    }

    /**
     * Utilisateur ayant approuvé la réactivation (self-relation).
     */
    public function reactivationApprovedBy()
    {
        return $this->belongsTo(User::class, 'reactivation_approved_by');
    }

    /**
     * Utilisateur ayant mis à jour cet utilisateur (self-relation).
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Artistes créés par cet utilisateur.
     */
    public function createdArtistes()
    {
        return $this->hasMany(Artiste::class, 'created_by');
    }

    /**
     * Artistes mis à jour par cet utilisateur.
     */
    public function updatedArtistes()
    {
        return $this->hasMany(Artiste::class, 'updated_by');
    }

    /**
     * Faqs créées par cet utilisateur.
     */
    public function createdFaqs()
    {
        return $this->hasMany(Faq::class, 'created_by');
    }

    /**
     * Faqs mises à jour par cet utilisateur.
     */
    public function updatedFaqs()
    {
        return $this->hasMany(Faq::class, 'updated_by');
    }

    /**
     * Stands créés par cet utilisateur.
     */
    public function createdStands()
    {
        return $this->hasMany(Stand::class, 'created_by');
    }

    /**
     * Stands mis à jour par cet utilisateur.
     */
    public function updatedStands()
    {
        return $this->hasMany(Stand::class, 'updated_by');
    }

    /**
     * OrderItems mis à jour par cet utilisateur.
     */
    public function updatedOrderItems()
    {
        return $this->hasMany(OrderItem::class, 'updated_by');
    }

    /**
     * ProductsVariants mis à jour par cet utilisateur.
     */
    public function updatedProductsVariants()
    {
        return $this->hasMany(ProductsVariant::class, 'updated_by');
    }

    /**
     * Partenaires créés par cet utilisateur.
     */
    public function createdPartenaires()
    {
        return $this->hasMany(Partenaire::class, 'created_by');
    }

    /**
     * Partenaires mis à jour par cet utilisateur.
     */
    public function updatedPartenaires()
    {
        return $this->hasMany(Partenaire::class, 'updated_by');
    }

    /**
     * Orders mis à jour par cet utilisateur.
     */
    public function updatedOrders()
    {
        return $this->hasMany(Order::class, 'updated_by');
    }

    /**
     * Products créés par cet utilisateur.
     */
    public function createdProducts()
    {
        return $this->hasMany(Product::class, 'created_by');
    }

    /**
     * Products mis à jour par cet utilisateur.
     */
    public function updatedProducts()
    {
        return $this->hasMany(Product::class, 'updated_by');
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
        $this->notify(new VerifyEmailNotification());
    }
}
