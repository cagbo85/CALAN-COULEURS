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
 * @property string|null $payment_status
 * @property string|null $cashout_state
 * @property string|null $helloasso_payment_id
 * @property Carbon|null $paid_at
 * @property array|null $payment_metadata
 * @property string $token
 * @property bool $stock_decremented
 * @property string $status
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|OrderItem[] $order_items
 * @property Collection|Shipment[] $shipments
 *
 * @package App\Models
 */
class Order extends Model
{
    use HasFactory;
	protected $table = 'orders';

	protected $casts = [
		'total_amount' => 'float',
		'paid_at' => 'datetime',
		'payment_metadata' => 'json',
		'stock_decremented' => 'bool',
		'updated_by' => 'int'
	];

	protected $hidden = [
		'token'
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
		'payment_status',
		'cashout_state',
		'helloasso_payment_id',
		'paid_at',
		'payment_metadata',
		'token',
		'stock_decremented',
		'status',
		'updated_by'
	];

	/**
     * Utilisateur ayant mis à jour cette commande.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Items associés à cette commande.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

	public function shipments()
	{
		return $this->hasMany(Shipment::class, 'order_id');
	}
}
