<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Color
 *
 * @property int $id
 * @property string $name
 * @property string|null $hex_code
 * @property int $ordre
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|ProductsVariant[] $products_variants
 *
 * @package App\Models
 */
class Color extends Model
{
    use HasFactory;
	protected $table = 'colors';

	protected $casts = [
		'ordre' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'hex_code',
		'ordre',
		'created_by',
		'updated_by'
	];

    /**
     * Utilisateur ayant créé cette couleur.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour cette couleur.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Variantes de produits associées à cette couleur.
     */
    public function productsVariants()
    {
        return $this->hasMany(ProductsVariant::class, 'color_id');
    }
}
