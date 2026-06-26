<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Récapitulatif de commande</title>
</head>

<body style="font-family: Arial, sans-serif; color: #1d3f89; background-color: #f3f4f6; margin: 0; padding: 20px;">

    <div class="card"
        style="max-width: 700px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">

        <div class="header" style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%); color: #ffffff; padding: 25px 20px;">
            <h1 style="margin: 0; font-size: 24px; font-weight: bold; tracking-tight;">Calan'Couleurs</h1>
            <p style="margin: 6px 0 0 0; font-size: 14px; opacity: 0.9;">Merci pour votre commande</p>
        </div>

        <div class="content" style="padding: 24px;">
            <p style="margin-top: 0; font-size: 15px; line-height: 1.5;">Bonjour {{ $order->firstname }}
                {{ $order->lastname }},</p>
            <p style="font-size: 15px; line-height: 1.5;">Votre paiement a bien été confirmé. Voici le récapitulatif de
                votre commande.</p>

            <p class="muted" style="color: #6b7280; font-size: 13px; line-height: 1.6; margin: 20px 0;">
                <strong>Référence commande :</strong> #{{ $order->id }}<br>
                <strong>Date de paiement :</strong>
                {{ optional($order->paid_at)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}
            </p>

            <table style="width: 100%; border-collapse: collapse; margin-top: 16px; margin-bottom: 16px;">
                <thead>
                    <tr>
                        <th
                            style="border-bottom: 2px solid #e5e7eb; padding: 12px 10px; text-align: left; font-size: 13px; font-weight: bold; text-transform: uppercase; background-color: #f9fafb; color: #374151;">
                            Article</th>
                        <th
                            style="border-bottom: 2px solid #e5e7eb; padding: 12px 10px; text-align: left; font-size: 13px; font-weight: bold; text-transform: uppercase; background-color: #f9fafb; color: #374151;">
                            Détails</th>
                        <th
                            style="border-bottom: 2px solid #e5e7eb; padding: 12px 10px; text-align: center; font-size: 13px; font-weight: bold; text-transform: uppercase; background-color: #f9fafb; color: #374151;">
                            Quantité</th>
                        <th
                            style="border-bottom: 2px solid #e5e7eb; padding: 12px 10px; text-align: right; font-size: 13px; font-weight: bold; text-transform: uppercase; background-color: #f9fafb; color: #374151;">
                            Prix unitaire</th>
                        <th
                            style="border-bottom: 2px solid #e5e7eb; padding: 12px 10px; text-align: right; font-size: 13px; font-weight: bold; text-transform: uppercase; background-color: #f9fafb; color: #374151;">
                            Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        @php
                            $productTitle = $item->product?->title ?? 'Produit';
                            $size = $item->productsVariant?->size?->label;
                            $color = $item->productsVariant?->color?->name;
                            $lineTotal = $item->quantity * $item->unit_price;
                            $details = trim(
                                ($size ? 'Taille ' . $size : '') .
                                    ($size && $color ? ' / ' : '') .
                                    ($color ? 'Couleur ' . $color : ''),
                            );
                        @endphp
                        <tr>
                            <td
                                style="border-bottom: 1px solid #e5e7eb; padding: 12px 10px; font-size: 14px; color: #1d3f89; font-weight: bold;">
                                {{ $productTitle }}</td>
                            <td
                                style="border-bottom: 1px solid #e5e7eb; padding: 12px 10px; font-size: 14px; color: #4b5563;">
                                {{ $details !== '' ? $details : '-' }}</td>
                            <td
                                style="border-bottom: 1px solid #e5e7eb; padding: 12px 10px; font-size: 14px; color: #1d3f89; text-align: center;">
                                {{ $item->quantity }}</td>
                            <td
                                style="border-bottom: 1px solid #e5e7eb; padding: 12px 10px; font-size: 14px; color: #1d3f89; text-align: right; white-space: nowrap;">
                                {{ number_format($item->unit_price, 2, ',', ' ') }}&nbsp;€</td>
                            <td
                                style="border-bottom: 1px solid #e5e7eb; padding: 12px 10px; font-size: 14px; color: #1d3f89; text-align: right; font-weight: bold; white-space: nowrap;">
                                {{ number_format($lineTotal, 2, ',', ' ') }}&nbsp;€</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="total"
                style="margin-top: 20px; margin-bottom: 24px; font-size: 18px; font-weight: bold; text-align: right; color: #1d3f89;">
                Total : <span
                    style="color: #1d3f89; font-size: 22px; font-weight: 800;">{{ number_format($order->total_amount, 2, ',', ' ') }}&nbsp;€</span>
            </p>

            <p style="font-size: 14px; color: #4b5563; line-height: 1.5; margin-top: 30px;">Vous recevrez un autre email
                dès qu'il y aura une mise à jour de livraison.</p>
            <p class="muted"
                style="color: #9ca3af; font-size: 12px; margin-top: 15px; border-top: 1px solid #f3f4f6; padding-top: 15px;">
                Email automatique, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>

</html>
