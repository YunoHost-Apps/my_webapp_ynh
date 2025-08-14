<?php
// Endpoint sécurisé pour récupérer les identifiants SFTP
// Ce fichier vérifie que l'utilisateur est connecté via SSO YunoHost

// Vérifier que l'utilisateur est connecté via SSO
if (!isset($_SERVER['REMOTE_USER']) || empty($_SERVER['REMOTE_USER'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied - User not authenticated']);
    exit;
}

// Vérifier que le fichier de mot de passe existe
$install_dir = dirname($_SERVER['DOCUMENT_ROOT']);
$sftp_file = $install_dir . '/sftp_password.txt';

if (!file_exists($sftp_file) || !is_readable($sftp_file)) {
    http_response_code(404);
    echo json_encode(['error' => 'SFTP credentials file not found']);
    exit;
}

// Lire le contenu du fichier
$content = file_get_contents($sftp_file);
if ($content === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Unable to read SFTP credentials file']);
    exit;
}

// Retourner le contenu en JSON
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'content' => $content,
    'file_path' => $sftp_file
]);
?>
