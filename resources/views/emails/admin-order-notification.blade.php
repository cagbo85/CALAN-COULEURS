<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Nouvelle commande reçue !</title>
</head>

<body style="font-family: Arial, sans-serif; color: #1d3f89; background-color: #f3f4f6; margin: 0; padding: 20px;">

    <div class="card"
        style="max-width: 700px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">

        <div class="header"
            style="background: linear-gradient(135deg, #e67e22 40%, #f39c12 100%); color: #ffffff; padding: 25px 20px;">
            <h1 style="margin: 0; font-size: 24px; font-weight: bold;">🔔 Alerte Boutique Calan'Couleurs</h1>
            <p style="margin: 6px 0 0 0; font-size: 14px; opacity: 0.9;">Une nouvelle commande vient d'être payée avec
                succès !</p>
        </div>

        <div class="content" style="padding: 24px;">
            <h2
                style="color: #1d3f89; font-size: 18px; margin-top: 0; border-bottom: 2px solid #f3f4f6; padding-bottom: 8px;">
                Informations Client</h2>
            <p style="font-size: 15px; line-height: 1.5; margin: 10px 0;">
                <strong>Nom :</strong> {{ $order->firstname }} {{ $order->lastname }}<br>
                <strong>Email :</strong> <a href="mailto:{{ $order->email }}"
                    style="color: #1d3f89;">{{ $order->email }}</a><br>
                <strong>Adresse de livraison :</strong><br>
                {{ $order->adresse }}, {{ $order->code_postal }} {{ $order->ville }} ({{ $order->pays }})
            </p>

            <h2
                style="color: #1d3f89; font-size: 18px; margin-top: 25px; border-bottom: 2px solid #f3f4f6; padding-bottom: 8px;">
                Détails de la commande</h2>
            <p class="muted" style="color: #6b7280; font-size: 13px; margin: 10px 0;">
                <strong>Référence interne :</strong> #{{ $order->id }}<br>
                <strong>Référence HelloAsso :</strong> {{ $order->helloasso_id ?? 'N/A' }}<br>
                <strong>Date du paiement :</strong>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        @php
                            $productTitle = $item->product?->title ?? 'Produit';
                            $size = $item->productsVariant?->size?->label;
                            $color = $item->productsVariant?->color?->name;
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
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="margin-top: 20px; font-size: 18px; font-weight: bold; text-align: right; color: #1d3f89;">
                Montant total payé : <span
                    style="color: #e67e22; font-size: 22px; font-weight: 800;">{{ number_format($order->total_amount, 2, ',', ' ') }}&nbsp;€</span>
            </p>

            <p class="muted"
                style="color: #9ca3af; font-size: 12px; margin-top: 30px; border-top: 1px solid #f3f4f6; padding-top: 15px; text-align: center;">
                Pensez à préparer le colis rapidement ! 📦
            </p>
        </div>
    </div>
</body>

</html>
