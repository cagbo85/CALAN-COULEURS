<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Edition
 *
 * @property int $id
 * @property Carbon $year
 * @property string|null $name
 * @property Carbon $begin_date
 * @property Carbon $ending_date
 * @property bool $actif
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|Artiste[] $artistes
 * @property Collection|Partenaire[] $partenaires
 * @property Collection|Stand[] $stands
 *
 * @package App\Models
 */
class Edition extends Model
{
    use HasFactory;
	protected $table = 'editions';

	protected $casts = [
		'year' => 'datetime',
		'begin_date' => 'datetime',
		'ending_date' => 'datetime',
		'actif' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'year',
		'name',
		'begin_date',
		'ending_date',
		'actif',
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
     * Les artistes associés à cette édition.
     */
	public function artistes()
	{
		return $this->belongsToMany(Artiste::class, 'edition_artistes');
	}

    /**
     * Les partenaires associés à cette édition.
     */
	public function partenaires()
	{
		return $this->belongsToMany(Partenaire::class, 'edition_partenaires');
	}

    /**
     * Les stands associés à cette édition.
     */
	public function stands()
	{
		return $this->belongsToMany(Stand::class, 'edition_stands');
	}
}
