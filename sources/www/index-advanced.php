<?php
/**
 * Front Controller Avancé - My Webapp
 * 
 * Ce fichier est le point d'entrée principal pour le mode Advanced.
 * Il est placé dans le dossier /www/public et gère toutes les requêtes.
 */

// Configuration de base
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrage de la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Définition des constantes de base
define('APP_ROOT', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);
define('SRC_PATH', APP_ROOT . '/src');
define('VENDOR_PATH', APP_ROOT . '/vendor');

// Autoloader simple (si Composer n'est pas utilisé)
if (file_exists(VENDOR_PATH . '/autoload.php')) {
    require VENDOR_PATH . '/autoload.php';
} else {
    // Autoloader basique pour les classes dans src/
    spl_autoload_register(function ($class) {
        $file = SRC_PATH . '/' . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    });
}

// Récupération de l'URI demandée
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Gestion des routes avec système de routing avancé
$routes = [
    '/' => 'views/home.php',
    '/about' => 'views/about.php',
    '/contact' => 'views/contact.php',
    '/api/status' => 'api/status.php',
    '/admin' => 'admin/dashboard.php'
];

// Vérification si la route existe
if (isset($routes[$path])) {
    $view_file = $routes[$path];
    if (file_exists($view_file)) {
        include $view_file;
    } else {
        // Vue non trouvée
        http_response_code(404);
        include 'views/404.php';
    }
} else {
    // Route non trouvée
    http_response_code(404);
    include 'views/404.php';
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
        echo "<p>Créez ce fichier dans le dossier public/ pour personnaliser votre application.</p>";
    }
}

/**
 * Fonction pour obtenir l'URL de base de l'application
 */
function base_url($path = '') {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base = dirname($_SERVER['SCRIPT_NAME']);
    return $protocol . '://' . $host . $base . '/' . ltrim($path, '/');
}
?>
