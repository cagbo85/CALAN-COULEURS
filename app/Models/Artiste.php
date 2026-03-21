<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Artiste
 *
 * @property int $id
 * @property string $name
 * @property string|null $style
 * @property string|null $description
 * @property string|null $photo
 * @property string|null $soundcloud_url
 * @property string|null $spotify_url
 * @property string|null $youtube_url
 * @property string|null $deezer_url
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User|null $user
 * @property Collection|Performance[] $performances
 */
class Artiste extends Model
{
    use HasFactory;

    protected $table = 'artistes';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'name',
        'style',
        'description',
        'photo',
        'soundcloud_url',
        'spotify_url',
        'youtube_url',
        'deezer_url',
        'created_by',
        'updated_by',
    ];

    /**
     * Utilisateur ayant créé cet artiste.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour cet artiste.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Les performances associées à cet artiste.
     */
    public function performances()
    {
        return $this->belongsToMany(Performance::class, 'performances')
            ->withPivot('actif');
    }
}
