<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Faq
 *
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property bool $actif
 * @property int $ordre
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 *
 * @package App\Models
 */
class Faq extends Model
{
    use HasFactory;
	protected $table = 'faqs';

	protected $casts = [
		'actif' => 'bool',
		'ordre' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'question',
		'answer',
		'actif',
		'ordre',
		'created_by',
		'updated_by'
	];

	/**
     * Utilisateur ayant créé cette FAQ.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour cette FAQ.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
