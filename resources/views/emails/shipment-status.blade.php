<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Mise à jour de livraison</title>
</head>

<body style="font-family: Arial, sans-serif; color: #1d3f89; background-color: #f3f4f6; margin: 0; padding: 20px;">
    @php
        $order = $shipment->order ?? $shipment->orderId;
        $statusLabels = [
            'in preparation' => 'En préparation',
            'shipped' => 'Expédiée',
            'delivered' => 'Livrée',
            'returned' => 'Retournée',
        ];
        $statusLabel = $statusLabels[$shipment->status] ?? $shipment->status;
    @endphp
    <div class="card"
        style="max-width: 700px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">

        <div class="header"
            style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%); color: #ffffff; padding: 25px 20px;">
            <h1 style="margin: 0; font-size: 24px; font-weight: bold; tracking-tight;">Calan'Couleurs</h1>
            <p style="margin: 6px 0 0 0; font-size: 14px; opacity: 0.9;">Mise à jour de votre livraison</p>
        </div>

        <div class="content" style="padding: 24px;">
            <p style="margin-top: 0; font-size: 15px; line-height: 1.5;">Bonjour {{ $order->firstname }}
                {{ $order->lastname }},</p>
            <p style="font-size: 15px; line-height: 1.5;">Le statut de livraison de votre commande #{{ $order->id }}
                a été mis à jour.</p>

            <div class="bloc" style="margin: 20px 0; padding: 16px; background-color: #f9fafb; border-radius: 8px;">
                <p style="margin:0 0 8px 0;"><strong>Statut:</strong> {{ $statusLabel }}</p>
                <p style="margin:0 0 8px 0;"><strong>Transporteur:</strong> {{ $shipment->carrier ?: 'Non renseigné' }}
                </p>
                <p style="margin:0 0 8px 0;"><strong>Numéro de suivi:</strong>
                    {{ $shipment->tracking_number ?: 'Non renseigné' }}</p>
            </div>

            <p style="font-size: 14px; color: #4b5563; line-height: 1.5; margin-top: 30px;">Pour rappel, c'est nous même
                qui gérons vos commandes et les livraisons.<br> Vous recevrez un autre email
                dès qu'il y aura une mise à jour de livraison.</p>
            <p class="muted"
                style="color: #9ca3af; font-size: 12px; margin-top: 15px; border-top: 1px solid #f3f4f6; padding-top: 15px;">
                Email automatique, merci de ne pas y répondre.</p>

        </div>
</body>
