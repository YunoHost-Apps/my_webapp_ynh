<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - My Webapp</title>
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
        <h1>ℹ️ À propos de My Webapp</h1>
        <p>Informations sur votre application</p>
    </div>

    <div class="nav">
        <a href="/">Accueil</a>
        <a href="/about">À propos</a>
        <a href="/contact">Contact</a>
    </div>

    <div class="content">
        <h2>À propos de cette application</h2>
        
        <p>Cette page démontre le fonctionnement du système de routing de votre application.</p>
        
        <h3>Fonctionnalités du Front Controller :</h3>
        <ul>
            <li>✅ Routing automatique basé sur l'URL</li>
            <li>✅ Gestion centralisée des requêtes</li>
            <li>✅ Séparation des vues et de la logique</li>
            <li>✅ Gestion des erreurs 404</li>
            <li>✅ Structure modulaire extensible</li>
        </ul>

        <h3>Comment ça marche :</h3>
        <p>Quand vous accédez à <code>/about</code>, le Front Controller :</p>
        <ol>
            <li>Intercepte la requête</li>
            <li>Analyse l'URL demandée</li>
            <li>Détermine quelle vue afficher</li>
            <li>Charge le fichier <code>views/about.php</code></li>
            <li>Affiche le contenu</li>
        </ol>

        <h3>Personnalisation :</h3>
        <p>Pour ajouter de nouvelles pages :</p>
        <ol>
            <li>Créez un nouveau fichier dans le dossier <code>views/</code></li>
            <li>Ajoutez la route dans <code>index.php</code></li>
            <li>Votre page sera accessible immédiatement</li>
        </ol>

        <h3>Informations techniques :</h3>
        <ul>
            <li><strong>URL actuelle :</strong> <?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></li>
            <li><strong>Fichier chargé :</strong> <?php echo htmlspecialchars(__FILE__); ?></li>
            <li><strong>Timestamp :</strong> <?php echo date('Y-m-d H:i:s'); ?></li>
        </ul>
    </div>

    <div class="footer">
        <p>My Webapp - Page "À propos" générée dynamiquement</p>
    </div>
</body>
</html>
