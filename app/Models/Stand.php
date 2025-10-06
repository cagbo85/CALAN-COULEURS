<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stand
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $photo
 * @property string $type
 * @property string|null $instagram_url
 * @property string|null $facebook_url
 * @property string|null $website_url
 * @property string|null $other_link
 * @property bool $actif
 * @property int $ordre
 * @property Carbon|null $year
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 *
 * @package App\Models
 */
class Stand extends Model
{
    use HasFactory;
    protected $table = 'stands';

    protected $casts = [
        'actif' => 'bool',
        'ordre' => 'int',
        'year' => 'datetime',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'name',
        'description',
        'photo',
        'type',
        'instagram_url',
        'facebook_url',
        'website_url',
        'other_link',
        'actif',
        'ordre',
        'year',
        'created_by',
        'updated_by'
    ];

    /**
     * Utilisateur ayant créé ce stand.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour ce stand.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
