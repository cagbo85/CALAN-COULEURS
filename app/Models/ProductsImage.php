<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsImage
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $variant_id
 * @property string $image
 * @property int $ordre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Product|null $product
 * @property ProductsVariant|null $products_variant
 *
 * @package App\Models
 */
class ProductsImage extends Model
{
    use HasFactory;
	protected $table = 'products_images';

	protected $casts = [
		'product_id' => 'int',
		'variant_id' => 'int',
		'ordre' => 'int'
	];

	protected $fillable = [
		'product_id',
		'variant_id',
		'image',
		'ordre'
	];

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id');
	}

	public function variant()
	{
		return $this->belongsTo(ProductsVariant::class, 'variant_id');
	}
}
