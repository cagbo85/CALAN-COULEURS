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
 * Class Order
 *
 * @property int $id
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string|null $adresse
 * @property string|null $ville
 * @property string|null $departement
 * @property string|null $code_postal
 * @property string|null $pays
 * @property float $total_amount
 * @property string $helloasso_id
 * @property string|null $shipping_tracking_number
 * @property string|null $shipping_carrier
 * @property Carbon|null $shipping_date
 * @property Carbon|null $delivered_date
 * @property string|null $shipping_status
 * @property string $status
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|OrderItem[] $order_items
 *
 * @package App\Models
 */
class Order extends Model
{
    use HasFactory;
	protected $table = 'orders';

	protected $casts = [
		'total_amount' => 'float',
		'shipping_date' => 'datetime',
		'delivered_date' => 'datetime',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'email',
		'firstname',
		'lastname',
		'adresse',
		'ville',
		'departement',
		'code_postal',
		'pays',
		'total_amount',
		'helloasso_id',
		'shipping_tracking_number',
		'shipping_carrier',
		'shipping_date',
		'delivered_date',
		'shipping_status',
		'status',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function order_items()
	{
		return $this->hasMany(OrderItem::class);
	}
}
