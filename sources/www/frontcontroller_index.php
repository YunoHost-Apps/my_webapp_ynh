<?php
/**
 * Front Controller Index - WordPress/Drupal Style
 * 
 * Ce fichier est le point d'entrée principal pour les applications
 * de type WordPress, Drupal, ou autres CMS utilisant un front controller.
 * 
 * Placez vos fichiers d'application à la racine du répertoire www/
 * (ex: wp-config.php, wp-content/, drupal/, etc.)
 * 
 * Ce fichier redirige les requêtes vers l'application réelle.
 */

// Template minimal - l'application réelle fournira son propre index.php
// Vous pouvez personnaliser ce fichier selon vos besoins

// Exemple pour WordPress:
// require_once __DIR__ . '/wp-config.php';
// require_once __DIR__ . '/wp-load.php';

// Exemple pour Drupal:
// require_once __DIR__ . '/autoload.php';
// $kernel = new Drupal\Core\DrupalKernel('prod', FALSE);
// $response = $kernel->handle($request);

// Pour l'instant, affichons une page d'information
?>
<!DOCTYPE html>
<html>
<head>
    <title>Front Controller - Installation Required</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 600px; margin: 0 auto; }
        .info { background: #f0f0f0; padding: 20px; border-radius: 5px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Front Controller Mode</h1>
        <div class="info">
            <p>Ce répertoire est configuré en mode <strong>Front Controller</strong>.</p>
            <p>Placez vos fichiers d'application (WordPress, Drupal, etc.) à la racine du répertoire <code>www/</code>.</p>
        </div>
        <div class="warning">
            <p><strong>Note:</strong> Ce fichier est un template. Remplacez-le par votre application réelle.</p>
        </div>
    </div>
</body>
</html>
