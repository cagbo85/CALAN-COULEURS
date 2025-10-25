<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EditionStand
 *
 * @property int $edition_id
 * @property int $stand_id
 * @property bool $actif
 * @property Carbon|null $created_at
 *
 * @property Edition $edition
 * @property Stand $stand
 *
 * @package App\Models
 */
class EditionStand extends Model
{
    use HasFactory;
	protected $table = 'edition_stands';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'edition_id' => 'int',
		'stand_id' => 'int',
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
     * Le stand associé.
     */
	public function stand()
	{
		return $this->belongsTo(Stand::class, 'stand_id');
	}
}
