<?php

namespace App\Mail;

use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShipmentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public Shipment $shipment;

    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    public function build()
    {
        $order = $this->shipment->order ?? $this->shipment->orderId;

        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->to($order->email)
            ->subject('Mise a jour de livraison de votre commande')
            ->view('emails.shipment-status');
    }
}
