<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EditionArtiste
 *
 * @property int $edition_id
 * @property int $artiste_id
 * @property bool $actif
 * @property Carbon|null $created_at
 *
 * @property Edition $edition
 * @property Artiste $artiste
 *
 * @package App\Models
 */
class EditionArtiste extends Model
{
    use HasFactory;
	protected $table = 'edition_artistes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'edition_id' => 'int',
		'artiste_id' => 'int',
		'actif' => 'bool'
	];

	protected $fillable = [
		'actif'
	];

	/**
     * L'édition associée.
     */
	public function edition()
	{
		return $this->belongsTo(Edition::class, 'edition_id');
	}

    /**
     * L'artiste associé.
     */
	public function artiste()
	{
		return $this->belongsTo(Artiste::class, 'artiste_id');
	}
}
