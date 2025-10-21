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
 * @property string|null $sku
 * @property int|null $color_id
 * @property int|null $size_id
 * @property int $quantity
 * @property string|null $image
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Product $product
 * @property Size|null $size
 * @property Color|null $color
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
        'color_id' => 'int',
        'size_id' => 'int',
        'quantity' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'product_id',
        'sku',
        'color_id',
        'size_id',
        'quantity',
        'image',
        'created_by',
        'updated_by'
    ];

    /**
     * Utilisateur ayant créé cette variante.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant mis à jour cette variante.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Produit parent de cette variante.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Taille associée à cette variante.
     */
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    /**
     * Couleur associée à cette variante.
     */
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    /**
     * Items de commande associés à cette variante.
     */
    public function OrderItem()
    {
        return $this->hasMany(OrderItem::class, 'variant_id');
    }
}
