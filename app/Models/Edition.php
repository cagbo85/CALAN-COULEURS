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
 * Class Edition
 *
 * @property int $id
 * @property int $year
 * @property string|null $name
 * @property string|null $reservation_url
 * @property Carbon $begin_date
 * @property Carbon $ending_date
 * @property bool $actif
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|Partenaire[] $partenaires
 * @property Collection|Stand[] $stands
 * @property Collection|Performance[] $performances
 *
 * @package App\Models
 */
class Edition extends Model
{
    use HasFactory;
    protected $table = 'editions';

    protected $casts = [
        'year' => 'int',
        'begin_date' => 'datetime',
        'ending_date' => 'datetime',
        'actif' => 'bool',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'year',
        'name',
        'reservation_url',
        'begin_date',
        'ending_date',
        'actif',
        'status',
        'created_by',
        'updated_by'
    ];

    /**
     * Utilisateur ayant créé cette édition.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour cette édition.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Les partenaires associés à cette édition.
     */
    public function partenaires()
    {
        return $this->belongsToMany(Partenaire::class, 'edition_partenaires')
            ->withPivot('actif');
    }

    /**
     * Les stands associés à cette édition.
     */
    public function stands()
    {
        return $this->belongsToMany(Stand::class, 'edition_stands')
            ->withPivot('actif');
    }

    /**
     * Les performances associées à cette édition.
     */
    public function performances()
    {
        return $this->hasMany(Performance::class, 'edition_id');
    }

    /**
     * Récupérer l'édition "courante" pour tout le site.
     * Priorité : ongoing > upcoming > past
     * Exclut : draft et archived
     */
    public static function getCurrentEdition()
    {
        return self::query()
            ->where('actif', true)
            ->whereIn('status', ['ongoing', 'upcoming', 'past'])
            ->selectRaw("
            *,
            CONCAT(
                UPPER(DATE_FORMAT(begin_date, '%W')), ' ',
                DAY(begin_date), ' & ',
                UPPER(DATE_FORMAT(
                    IF(DATE(ending_date) = DATE(begin_date),
                        ending_date,
                        DATE_SUB(ending_date, INTERVAL 1 DAY)
                    ), '%W')), ' ',
                DAY(IF(DATE(ending_date) = DATE(begin_date),
                        ending_date,
                        DATE_SUB(ending_date, INTERVAL 1 DAY))), ' ',
                UPPER(DATE_FORMAT(
                    IF(DATE(ending_date) = DATE(begin_date),
                        ending_date,
                        DATE_SUB(ending_date, INTERVAL 1 DAY)
                    ), '%M')), ' ',
                YEAR(ending_date)
            ) AS formatted_dates,
            CONCAT(
                DAY(begin_date), ' & ',
                DAY(IF(DATE(ending_date) = DATE(begin_date),
                        ending_date,
                        DATE_SUB(ending_date, INTERVAL 1 DAY))), ' ',
                (DATE_FORMAT(
                    IF(DATE(ending_date) = DATE(begin_date),
                        ending_date,
                        DATE_SUB(ending_date, INTERVAL 1 DAY)
                    ), '%M')), ' ',
                YEAR(ending_date)
            ) AS formatted_dates_2,
            CASE
                WHEN id = 1 THEN 'première édition'
                ELSE CONCAT(id, 'ème édition')
            END AS edition_label
        ")
            ->orderByRaw("FIELD(status, 'ongoing', 'upcoming', 'past')")
            ->orderByDesc('year')
            ->first();
    }
}
