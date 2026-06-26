<?php

namespace App\Observers;

use App\Mail\ShipmentStatusMail;
use App\Models\Shipment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ShipmentObserver
{
    /**
     * Handle the shipment "created" event.
     */
    public function created(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the shipment "updated" event.
     */
    public function updated(Shipment $shipment): void
    {
        Log::info('ShipmentObserver triggered', [
            'shipment_id' => $shipment->id,
            'old' => $shipment->getOriginal('status'),
            'new' => $shipment->status,
        ]);

        // On notifie uniquement quand le statut change
        if (! $shipment->wasChanged('status')) {
            return;
        }

        $status = $shipment->status;
        if (! in_array($status, ['shipped', 'delivered', 'returned'], true)) {
            return;
        }

        // Anti doublon sur le meme statut
        if ($shipment->last_notified_status === $status) {
            return;
        }

        $shipment->loadMissing('order');

        if (! $shipment->order || empty($shipment->order->email)) {
            Log::warning('ShipmentObserver: commande ou email client manquant', [
                'shipment_id' => $shipment->id,
                'order_id' => $shipment->order_id,
            ]);
            return;
        }

        Mail::send(new ShipmentStatusMail($shipment));

        // Mise a jour silencieuse pour ne pas re-trigger l observer
        $shipment->forceFill([
            'last_notified_status' => $status,
        ])->saveQuietly();
    }

    /**
     * Handle the shipment "deleted" event.
     */
    public function deleted(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the shipment "restored" event.
     */
    public function restored(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the shipment "force deleted" event.
     */
    public function forceDeleted(Shipment $shipment): void
    {
        //
    }
}
