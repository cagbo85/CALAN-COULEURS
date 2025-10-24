<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EditionPartenaire
 *
 * @property int $edition_id
 * @property int $partenaire_id
 * @property Carbon|null $created_at
 *
 * @property Edition $edition
 * @property Partenaire $partenaire
 *
 * @package App\Models
 */
class EditionPartenaire extends Model
{
    use HasFactory;
	protected $table = 'edition_partenaires';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'edition_id' => 'int',
		'partenaire_id' => 'int'
	];

	/**
     * L'édition associée.
     */
	public function edition()
	{
		return $this->belongsTo(Edition::class, 'edition_id');
	}

    /**
     * Le partenaire associé.
     */
	public function partenaire()
	{
		return $this->belongsTo(Partenaire::class, 'partenaire_id');
	}
}
