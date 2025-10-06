<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Partenaire
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $logo
 * @property string|null $photo
 * @property string|null $site_url
 * @property string|null $instagram_url
 * @property string|null $facebook_url
 * @property string|null $linkedin_url
 * @property string|null $autre_url
 * @property string|null $phone
 * @property string|null $adresse
 * @property string|null $ville
 * @property string|null $departement
 * @property string|null $code_postal
 * @property string|null $pays
 * @property float|null $latitude
 * @property float|null $longitude
 * @property bool $actif
 * @property int $ordre
 * @property Carbon|null $annee
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 *
 * @package App\Models
 */
class Partenaire extends Model
{
    use HasFactory;
    protected $table = 'partenaires';

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'actif' => 'bool',
        'ordre' => 'int',
        'annee' => 'datetime',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'name',
        'description',
        'logo',
        'photo',
        'site_url',
        'instagram_url',
        'facebook_url',
        'linkedin_url',
        'autre_url',
        'phone',
        'adresse',
        'ville',
        'departement',
        'code_postal',
        'pays',
        'latitude',
        'longitude',
        'actif',
        'ordre',
        'annee',
        'created_by',
        'updated_by'
    ];

    /**
     * Utilisateur ayant créé ce partenaire.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour ce partenaire.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
