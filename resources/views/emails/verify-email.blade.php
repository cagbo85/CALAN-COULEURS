<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vérification d'email - Calan'Couleurs</title>
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
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 24px;
            color: #272ac7;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 16px;
            margin-bottom: 20px;
            color: #555;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #272ac7 0%, #8f1e98 100%);
            color: white !important;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #eee;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            font-size: 14px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1 class="logo">Calan'Couleurs</h1>
            <p style="color: white; margin: 10px 0 0 0; font-size: 16px;">Administration</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2 class="greeting">Bonjour {{ $user->firstname }} !</h2>

            <p class="message">
                🎉 <strong>Bienvenue dans l'espace d'administration de Calan'Couleurs !</strong>
            </p>

            <p class="message">
                Votre compte a été initialisé avec succès. Pour finaliser l'activation et accéder à votre espace d'administration,
                veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email.
            </p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $verificationUrl }}" class="button">
                    ✉️ Vérifier mon adresse email
                </a>
            </div>

            <div class="warning">
                <strong>⏰ Important :</strong> Ce lien de vérification expirera dans <strong>60 minutes</strong>.
                Si le lien expire, vous pourrez en demander un nouveau depuis la page de connexion.
            </div>

            <p class="message">
                Une fois votre email vérifié, vous pourrez accéder à quelques-unes des fonctionnalités de l'administration, mais ceci dépend de votre rôle.
            </p>

            {{-- <ul style="color: #555; margin-left: 20px;">
                <li>📊 Gestion des événements</li>
                <li>👥 Administration des utilisateurs</li>
                <li>🎨 Gestion du contenu du site</li>
                <li>📧 Communication avec les membres</li>
            </ul> --}}

            <p class="message">
                Si vous rencontrez des difficultés, n'hésitez pas à contacter l'équipe technique.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>🎭 Calan'Couleurs</strong></p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 15px 0;">
            <p style="font-size: 12px;">
                Si vous n'avez pas demandé cette vérification, aucune action n'est requise.
                Ce message a été envoyé automatiquement, merci de ne pas y répondre.
            </p>
            <p style="font-size: 12px; color: #999;">
                Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :<br>
                <a href="{{ $verificationUrl }}" style="color: #272ac7; word-break: break-all;">{{ $verificationUrl }}</a>
            </p>
        </div>
    </div>
</body>
</html>
