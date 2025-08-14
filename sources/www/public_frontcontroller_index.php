<?php
/**
 * Front Controller Index - Laravel/Symfony Style
 * 
 * Ce fichier est le point d'entrée principal pour les applications
 * de type Laravel, Symfony, ou autres frameworks utilisant un répertoire public/.
 * 
 * Placez vos fichiers d'application dans le répertoire www/
 * (ex: vendor/, app/, bootstrap/, .env, composer.json, etc.)
 * 
 * Ce fichier dans www/public/ reçoit toutes les requêtes HTTP.
 */

// Template minimal - l'application réelle fournira son propre index.php
// Vous pouvez personnaliser ce fichier selon vos besoins

// Exemple pour Laravel:
// require_once __DIR__ . '/../vendor/autoload.php';
// $app = require_once __DIR__ . '/../bootstrap/app.php';
// $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
// $response = $kernel->handle($request);

// Exemple pour Symfony:
// require_once __DIR__ . '/../vendor/autoload.php';
// $kernel = new AppKernel('prod', false);
// $response = $kernel->handle($request);

// Pour l'instant, affichons une page d'information
?>
<!DOCTYPE html>
<html>
<head>
    <title>Front Controller Public - Installation Required</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 600px; margin: 0 auto; }
        .info { background: #f0f0f0; padding: 20px; border-radius: 5px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; }
        .structure { background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Front Controller Public Mode</h1>
        <div class="info">
            <p>Ce répertoire est configuré en mode <strong>Front Controller Public</strong>.</p>
            <p>Placez vos fichiers d'application (Laravel, Symfony, etc.) dans le répertoire <code>www/</code>.</p>
        </div>
        <div class="structure">
            <h3>Structure recommandée:</h3>
            <pre>www/
├── public/          ← Ce fichier (point d'entrée HTTP)
├── vendor/          ← Dépendances Composer
├── app/             ← Code de l'application
├── bootstrap/       ← Fichiers de démarrage
├── storage/         ← Fichiers de stockage
├── .env             ← Variables d'environnement
└── composer.json    ← Dépendances</pre>
        </div>
        <div class="warning">
            <p><strong>Note:</strong> Ce fichier est un template. Remplacez-le par votre application réelle.</p>
        </div>
    </div>
</body>
</html>
