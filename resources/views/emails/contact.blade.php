<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouveau message de contact - Calan'Couleurs</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #272ac7 0%, #8f1e98 50%, #ff0f63 100%);
            padding: 30px 20px;
            text-align: center;
        }
        .logo {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .header-subtitle {
            color: white;
            margin: 10px 0 0 0;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 22px;
            color: #272ac7;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message-box {
            background: #f8f9fa;
            border-left: 4px solid #8f1e98;
            border-radius: 0 8px 8px 0;
            padding: 20px 24px;
            margin: 24px 0;
            font-size: 15px;
            color: #444;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 15px;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #8f1e98;
            min-width: 60px;
        }
        .info-value {
            color: #333;
        }
        .info-value a {
            color: #272ac7;
            text-decoration: none;
        }
        .reply-note {
            background: #e8f4fd;
            border: 1px solid #bee3f8;
            padding: 14px 16px;
            border-radius: 6px;
            margin: 24px 0 0 0;
            font-size: 14px;
            color: #2b6cb0;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1 class="logo">Calan'Couleurs</h1>
            <p class="header-subtitle">✉️ Nouveau message de contact</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2 class="greeting">Vous avez reçu un nouveau message !</h2>

            <!-- Infos expéditeur -->
            <div>
                <div class="info-row">
                    <span class="info-label">Nom</span>
                    <span class="info-value">{{ $data['name'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">
                        <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
                    </span>
                </div>
            </div>

            <!-- Message -->
            <p style="margin: 24px 0 8px; font-weight: 600; color: #555; font-size: 15px;">
                Message :
            </p>
            <div class="message-box">{{ $data['message'] }}</div>

            <div class="reply-note">
                💡 <strong>Astuce :</strong> Vous pouvez répondre directement à cet email pour contacter
                <strong>{{ $data['name'] }}</strong> - la réponse lui sera envoyée automatiquement.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>🎭 Calan'Couleurs</strong></p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 15px 0;">
            <p style="font-size: 12px;">
                Ce message a été envoyé automatiquement depuis le formulaire de contact du site
                <a href="{{ config('app.url') }}" style="color: #272ac7;">calan-couleurs.fr</a>.
            </p>
        </div>
    </div>
</body>
</html>
