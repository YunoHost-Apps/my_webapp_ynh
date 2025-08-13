<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webapp - Mode Front Controller</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        .header {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .nav {
            background: #333;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }
        .nav a:hover {
            text-decoration: underline;
        }
        .content {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 My Webapp - Mode Front Controller</h1>
        <p>Application web avec système de routing avancé</p>
    </div>

    <div class="nav">
        <a href="/">Accueil</a>
        <a href="/about">À propos</a>
        <a href="/contact">Contact</a>
    </div>

    <div class="content">
        <h2>Bienvenue sur votre application !</h2>

        <p>Cette page est servie par le <strong>Front Controller</strong> de votre application.</p>

        <h3>Fonctionnalités disponibles :</h3>
        <ul>
            <li>✅ Système de routing automatique</li>
            <li>✅ Gestion centralisée des requêtes</li>
            <li>✅ Structure modulaire avec vues séparées</li>
            <li>✅ Support PHP-FPM intégré</li>
            <li>✅ Sécurité renforcée</li>
        </ul>

        <h3>Comment personnaliser :</h3>
        <p>Modifiez les fichiers dans le dossier <code>/var/www/my_webapp/www/</code> pour personnaliser votre application.</p>

        <p>Vous pouvez également utiliser SFTP pour transférer vos fichiers depuis un client externe.</p>

        <h3>Informations techniques :</h3>
        <ul>
            <li><strong>Mode :</strong> Front Controller</li>
            <li><strong>Point d'entrée :</strong> index.php</li>
            <li><strong>Serveur :</strong> NGINX + PHP-FPM</li>
            <li><strong>Architecture :</strong> MVC simple</li>
        </ul>

        <h3>Test PHP :</h3>
        <ul>
            <li><strong>URL actuelle :</strong> <?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></li>
            <li><strong>Fichier chargé :</strong> <?php echo htmlspecialchars(__FILE__); ?></li>
            <li><strong>Timestamp :</strong> <?php echo date('Y-m-d H:i:s'); ?></li>
        </ul>
    </div>

    <div class="footer">
        <p>My Webapp - Propulsé par YunoHost et le mode Front Controller</p>
    </div>
</body>
</html>
