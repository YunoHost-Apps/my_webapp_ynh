<?php
/**
 * My Webapp - Page d'accueil unifiée
 * 
 * Cette page s'adapte automatiquement selon le mode d'installation :
 * - standard : fichiers statiques
 * - front_controller_www : WordPress/Drupal style
 * - front_controller_public : Laravel/Symfony style
 */

// Détection du mode d'installation basée sur le chemin
try {
    $current_path = __DIR__;
    $install_mode = 'standard'; // valeur par défaut
    
    // Détection simple et robuste
    if (strpos($current_path, '/public') !== false) {
        $install_mode = 'front_controller_public';
    } elseif (basename($current_path) === 'www') {
        $install_mode = 'front_controller_www';
    }
} catch (Exception $e) {
    // En cas d'erreur, utiliser le mode standard
    $install_mode = 'standard';
}

// Permettre la surcharge via paramètre GET
$install_mode = $_GET['mode'] ?? $install_mode;
$with_sftp = $_GET['sftp'] ?? true;

// Gestion du mot de passe SFTP
$sftp_password = $_GET['password'] ?? '';
$use_current_user_password = $with_sftp && empty($sftp_password);

// Configuration des icônes et couleurs selon le mode
$mode_config = [
    'standard' => [
        'icon' => 'fas fa-file-code',
        'color' => '#3498db',
        'title' => 'Site Web Statique',
        'description' => 'Votre site web est configuré pour servir des fichiers statiques (HTML, CSS, JS).'
    ],
    'front_controller_www' => [
        'icon' => 'fab fa-wordpress',
        'color' => '#21759b',
        'title' => 'Application Web (Front Controller)',
        'description' => 'Votre application utilise un front controller à la racine (WordPress, Drupal, etc.).'
    ],
    'front_controller_public' => [
        'icon' => 'fab fa-laravel',
        'color' => '#ff2d20',
        'title' => 'Application Framework (Public)',
        'description' => 'Votre application utilise un répertoire public (Laravel, Symfony, etc.).'
    ]
];

$current_mode = $mode_config[$install_mode] ?? $mode_config['standard'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webapp - Installation Réussie</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: <?= $current_mode['color'] ?>;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --text-color: #2c3e50;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 3rem;
            max-width: 800px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-color);
        }
        
        .success-icon {
            font-size: 4rem;
            color: var(--success-color);
            margin-bottom: 1.5rem;
            animation: bounceIn 0.8s ease-out;
        }
        
        .cat-container {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .cat-reward {
            font-size: 1.1rem;
            color: var(--text-color);
            margin-bottom: 1rem;
            font-style: italic;
        }
        
        .cat-image-wrapper {
            display: inline-block;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 3px solid var(--primary-color);
            background: var(--light-bg);
            padding: 0.5rem;
        }
        
        .cat-gif {
            max-width: 300px;
            max-height: 200px;
            border-radius: 8px;
            display: block;
            transition: transform 0.3s ease;
        }
        
        .cat-image-wrapper:hover .cat-gif {
            transform: scale(1.05);
        }
        
        .mode-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--light-bg);
            color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            margin-bottom: 2rem;
            border: 2px solid var(--border-color);
        }
        
        .mode-icon {
            font-size: 1.2rem;
            color: var(--primary-color);
        }
        
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .description {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        
        .feature-card {
            background: var(--light-bg);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .feature-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .feature-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }
        
        .feature-text {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .sftp-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
        }
        
        .sftp-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .sftp-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .sftp-item {
            text-align: left;
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }
        
        .sftp-label {
            font-weight: 600;
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }
        
        .sftp-value {
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 0.9rem;
            opacity: 1;
        }
        
        .instructions {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: left;
        }
        
        .instructions-title {
            font-weight: 600;
            color: #856404;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .instructions-list {
            list-style: none;
            padding: 0;
        }
        
        .instructions-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #ffeaa7;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .instructions-list li:last-child {
            border-bottom: none;
        }
        
        .instructions-list .icon {
            color: var(--warning-color);
            width: 20px;
        }
        
        .footer {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 2rem 1.5rem;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .sftp-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Icône de succès avec petits chats -->
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <!-- Chat GIF aléatoire -->
        <div class="cat-container">
            <p class="cat-reward">As a reward, here is a random cat picture:</p>
            <div class="cat-image-wrapper">
                <img src="https://thecatapi.com/api/images/get?format=src&type=gif" alt="Random Cat GIF" class="cat-gif" onerror="this.style.display='none'">
            </div>
        </div>
        
        <!-- Indicateur de mode -->
        <div class="mode-indicator">
            <i class="<?= $current_mode['icon'] ?> mode-icon"></i>
            <span><?= $current_mode['title'] ?></span>
        </div>
        
        <!-- Titre principal -->
        <h1>Installation Réussie !</h1>
        
        <!-- Description -->
        <p class="description">
            <?= $current_mode['description'] ?>
            Votre application est maintenant prête à être utilisée.
        </p>
        
        <!-- Grille des fonctionnalités -->
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-server"></i>
                </div>
                <div class="feature-title">Serveur Web</div>
                <div class="feature-text">NGINX configuré et optimisé pour votre application</div>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="feature-title">Sécurité</div>
                <div class="feature-text">Permissions et accès sécurisés configurés</div>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-database"></i>
                </div>
                <div class="feature-title">Base de Données</div>
                <div class="feature-text">Configuration optimisée selon vos besoins</div>
            </div>
        </div>
        
        <?php if ($with_sftp): ?>
        <!-- Section SFTP -->
        <div class="sftp-section">
            <div class="sftp-title">
                <i class="fas fa-key"></i>
                Accès SFTP Configuré
            </div>
            <p>Vous pouvez maintenant éditer votre site via SFTP en utilisant les informations suivantes :</p>
            
            <?php if ($use_current_user_password): ?>
            <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 8px; margin: 1rem 0; text-align: center;">
                <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                <strong>Note :</strong> Aucun mot de passe spécifique n'a été défini. L'accès SFTP utilise le mot de passe de votre utilisateur YunoHost actuel.
            </div>
            <?php endif; ?>
            
            <div class="sftp-details">
                <div class="sftp-item">
                    <div class="sftp-label">Domaine</div>
                    <div class="sftp-value">__DOMAIN__</div>
                </div>
                <div class="sftp-item">
                    <div class="sftp-label">Port</div>
                    <div class="sftp-value">__SSH_PORT__</div>
                </div>
                <div class="sftp-item">
                    <div class="sftp-label">Utilisateur</div>
                    <div class="sftp-value">__ID__</div>
                </div>
                <div class="sftp-item">
                    <div class="sftp-label">Mot de passe</div>
                    <div class="sftp-value">
                        <?php if ($use_current_user_password): ?>
                            <span style="color: #f39c12;"><i class="fas fa-info-circle"></i> Mot de passe de l'utilisateur courant</span>
                        <?php else: ?>
                            Celui défini à l'installation
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Instructions selon le mode -->
        <div class="instructions">
            <div class="instructions-title">
                <i class="fas fa-info-circle"></i>
                Prochaines étapes
            </div>
            
            <?php if ($install_mode === 'standard'): ?>
            <ul class="instructions-list">
                <li><i class="fas fa-upload icon"></i>Uploadez vos fichiers HTML, CSS et JavaScript dans le répertoire <code>www/</code></li>
                <li><i class="fas fa-edit icon"></i>Remplacez ce fichier <code>index.php</code> par votre page d'accueil</li>
                <li><i class="fas fa-cog icon"></i>Configurez votre application selon vos besoins</li>
            </ul>
            
            <?php elseif ($install_mode === 'front_controller_www'): ?>
            <ul class="instructions-list">
                <li><i class="fas fa-download icon"></i>Téléchargez votre application (WordPress, Drupal, etc.) dans le répertoire <code>www/</code></li>
                <li><i class="fas fa-file-code icon"></i>Assurez-vous que <code>index.php</code> est à la racine de <code>www/</code></li>
                <li><i class="fas fa-database icon"></i>Configurez votre base de données si nécessaire</li>
            </ul>
            
            <?php else: // front_controller_public ?>
            <ul class="instructions-list">
                <li><i class="fas fa-download icon"></i>Téléchargez votre application (Laravel, Symfony, etc.) dans le répertoire <code>www/</code></li>
                <li><i class="fas fa-folder icon"></i>Assurez-vous que <code>index.php</code> est dans <code>www/public/</code></li>
                <li><i class="fas fa-cogs icon"></i>Configurez <code>.env</code> et vos dépendances</li>
            </ul>
            <?php endif; ?>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>
                Application créée avec <i class="fas fa-heart" style="color: var(--accent-color);"></i> 
                par <a href="https://yunohost.org" target="_blank">YunoHost</a>
            </p>
        </div>
    </div>
</body>
</html>
