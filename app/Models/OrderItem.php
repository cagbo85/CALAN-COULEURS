<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int|null $variant_id
 * @property int $quantity
 * @property float $unit_price
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Order $order
 * @property Product $product
 * @property ProductsVariant|null $products_variant
 * @property User|null $user
 *
 * @package App\Models
 */
class OrderItem extends Model
{
    use HasFactory;
	protected $table = 'order_items';

	protected $casts = [
		'order_id' => 'int',
		'product_id' => 'int',
		'variant_id' => 'int',
		'quantity' => 'int',
		'unit_price' => 'float',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'order_id',
		'product_id',
		'variant_id',
		'quantity',
		'unit_price',
		'updated_by'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function products_variant()
	{
		return $this->belongsTo(ProductsVariant::class, 'variant_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}
}
