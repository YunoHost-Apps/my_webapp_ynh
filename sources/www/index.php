<?php
/**
 * Front Controller - My Webapp
 * 
 * Ce fichier est le point d'entrée principal pour le mode Front Controller.
 * Toutes les requêtes passent par ce fichier pour une gestion centralisée.
 */

// Configuration de base
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrage de la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupération de l'URI demandée
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Gestion des routes de base
switch ($path) {
    case '/':
        // Page d'accueil
        include 'views/home.php';
        break;
        
    case '/about':
        // Page à propos
        include 'views/about.php';
        break;
        
    case '/contact':
        // Page de contact
        include 'views/contact.php';
        break;
        
    default:
        // Page 404 - Route non trouvée
        http_response_code(404);
        include 'views/404.php';
        break;
}

/**
 * Fonction utilitaire pour inclure des vues avec gestion d'erreur
 */
function safe_include($file_path) {
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo "<h1>Erreur</h1>";
        echo "<p>La vue demandée n'existe pas : $file_path</p>";
        echo "<p>Créez ce fichier pour personnaliser votre application.</p>";
    }
}
?>
