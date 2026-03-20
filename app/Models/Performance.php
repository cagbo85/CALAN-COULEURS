<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Performance
 *
 * @property int $id
 * @property int $edition_id
 * @property int $artiste_id
 * @property Carbon $begin_date
 * @property Carbon $ending_date
 * @property string $scene
 * @property string $day
 * @property bool $actif
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Edition $edition
 * @property Artiste $artiste
 * @property User|null $user
 */
class Performance extends Model
{
    use HasFactory;

    protected $table = 'performances';

    protected $casts = [
        'edition_id' => 'int',
        'artiste_id' => 'int',
        'begin_date' => 'datetime',
        'ending_date' => 'datetime',
        'actif' => 'bool',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'edition_id',
        'artiste_id',
        'begin_date',
        'ending_date',
        'scene',
        'day',
        'actif',
        'created_by',
        'updated_by',
    ];

    /**
     * Utilisateur ayant créé cette performance.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour cette performance.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Édition associée à cette performance.
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }

    /**
     * Artiste associé à cette performance.
     */
    public function artiste()
    {
        return $this->belongsTo(Artiste::class);
    }
}
