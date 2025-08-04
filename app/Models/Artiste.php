<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Artiste
 * 
 * @property int $id
 * @property string $name
 * @property string|null $style
 * @property string|null $description
 * @property string|null $photo
 * @property string $day
 * @property Carbon $begin_date
 * @property Carbon $ending_date
 * @property string $scene
 * @property string|null $soundcloud_url
 * @property string|null $spotify_url
 * @property string|null $youtube_url
 * @property string|null $deezer_url
 * @property bool $actif
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class Artiste extends Model
{
	protected $table = 'artistes';

	protected $casts = [
		'begin_date' => 'datetime',
		'ending_date' => 'datetime',
		'actif' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'style',
		'description',
		'photo',
		'day',
		'begin_date',
		'ending_date',
		'scene',
		'soundcloud_url',
		'spotify_url',
		'youtube_url',
		'deezer_url',
		'actif',
		'created_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}
}
