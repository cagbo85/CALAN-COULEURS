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
 * Class Shipment
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $tracking_number
 * @property string|null $carrier
 * @property Carbon|null $shipped_at
 * @property Carbon|null $delivered_at
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Order $order
 * @property User|null $user
 *
 * @package App\Models
 */
class Shipment extends Model
{
    use HasFactory;

	protected $table = 'shipments';

	protected $casts = [
		'order_id' => 'int',
		'shipped_at' => 'datetime',
		'delivered_at' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'order_id',
		'tracking_number',
		'carrier',
		'shipped_at',
		'delivered_at',
		'status',
		'created_by',
		'updated_by'
	];

    /**
     * Commande associée à cet envoi.
     */
	public function orderId()
	{
		return $this->belongsTo(Order::class, 'order_id');
	}

    /**
     * Utilisateur ayant créé cet envoi.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

	/**
     * Utilisateur ayant mis à jour cette commande.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
