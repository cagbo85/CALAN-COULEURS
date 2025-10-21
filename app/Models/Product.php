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
 * Class Product
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string|null $detailed_description
 * @property float $price
 * @property float|null $old_price
 * @property bool $is_featured
 * @property string|null $image
 * @property string $category
 * @property string|null $badge
 * @property bool $actif
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|OrderItem[] $order_items
 * @property Collection|ProductsVariant[] $products_variants
 *
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory;
	protected $table = 'products';

	protected $casts = [
		'price' => 'float',
		'old_price' => 'float',
		'is_featured' => 'bool',
		'actif' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'title',
		'slug',
		'description',
		'detailed_description',
		'price',
		'old_price',
		'is_featured',
		'image',
		'category',
		'badge',
		'actif',
		'created_by',
		'updated_by'
	];

	/**
     * Utilisateur ayant créé ce produit.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour ce produit.
     */
    public function updatedBy()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

    /**
     * OrderItems associés à ce produit.
     */
    public function orderItems()
	{
        return $this->hasMany(OrderItem::class, 'product_id');
	}

    /**
     * Variantes associées à ce produit.
     */
    public function productsVariants()
	{
        return $this->hasMany(ProductsVariant::class, 'product_id');
	}
}
