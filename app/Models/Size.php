<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Size
 *
 * @property int $id
 * @property string $label
 * @property string|null $description
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
class Size extends Model
{
    use HasFactory;
	protected $table = 'sizes';

	protected $casts = [
		'ordre' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'label',
		'description',
		'ordre',
		'created_by',
		'updated_by'
	];

    /**
     * Utilisateur ayant créé cette taille.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour cette taille.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Variantes de produits associées à cette taille.
     */
    public function productsVariants()
    {
        return $this->hasMany(ProductsVariant::class, 'size_id');
    }
}
