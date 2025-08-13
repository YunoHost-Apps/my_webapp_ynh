<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webapp - Mode Advanced</title>
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
        <h1>🚀 My Webapp - Mode Advanced</h1>
        <p>Application web avec structure public/privé</p>
    </div>

    <div class="nav">
        <a href="/">Accueil</a>
        <a href="/about">À propos</a>
        <a href="/contact">Contact</a>
    </div>

    <div class="content">
        <h2>Bienvenue sur votre application Advanced !</h2>

        <p>Cette page est servie depuis le dossier <code>/www/public</code> de votre application.</p>

        <h3>Structure du projet :</h3>
        <ul>
            <li><code>/www/public/</code> - Fichiers publics accessibles via le web</li>
            <li><code>/www/src/</code> - Code source de l'application (privé)</li>
            <li><code>/www/vendor/</code> - Dépendances (privées)</li>
            <li><code>/www/admin/</code> - Interface d'administration</li>
            <li><code>/www/api/</code> - API de l'application</li>
        </ul>

        <h3>Avantages de ce mode :</h3>
        <ul>
            <li>✅ Séparation claire entre code public et privé</li>
            <li>✅ Sécurité renforcée (code source non accessible)</li>
            <li>✅ Compatible avec les frameworks modernes</li>
            <li>✅ Structure professionnelle</li>
        </ul>

        <h3>Test PHP :</h3>
        <ul>
            <li><strong>URL actuelle :</strong> <?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></li>
            <li><strong>Fichier chargé :</strong> <?php echo htmlspecialchars(__FILE__); ?></li>
            <li><strong>Racine de l'app :</strong> <?php echo htmlspecialchars(dirname(__DIR__)); ?></li>
            <li><strong>Timestamp :</strong> <?php echo date('Y-m-d H:i:s'); ?></li>
        </ul>
    </div>

    <div class="footer">
        <p>My Webapp - Mode Advanced avec structure public/privé</p>
    </div>
</body>
</html>
