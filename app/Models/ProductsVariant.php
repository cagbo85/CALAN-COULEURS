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
 * Class ProductsVariant
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $size
 * @property string|null $color
 * @property int $quantity
 * @property string|null $image
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Product $product
 * @property Collection|OrderItem[] $order_items
 *
 * @package App\Models
 */
class ProductsVariant extends Model
{
    use HasFactory;
	protected $table = 'products_variants';

	protected $casts = [
		'product_id' => 'int',
		'quantity' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'product_id',
		'size',
		'color',
		'quantity',
		'image',
		'created_by',
		'updated_by'
	];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
