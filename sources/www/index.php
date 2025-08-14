<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webapp - PHP Info</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: #28a745;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .info-message {
            background: #e8f4fd;
            border: 1px solid #b3d9ff;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .info-message h2 {
            color: #2c5aa0;
            margin-bottom: 15px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .feature-card {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 20px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .feature-card .icon {
            font-size: 2rem;
            margin-bottom: 15px;
            color: #28a745;
        }

        .feature-card h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.5;
        }

        .php-info-section {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 20px;
            margin: 30px 0;
        }

        .php-info-section h3 {
            color: #495057;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .php-info-section p {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .status-badge {
            background: #28a745;
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            text-align: center;
            margin: 20px 0;
            font-weight: 600;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 0.9rem;
        }

        .sftp-credentials {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 20px;
            margin: 30px 0;
        }

        .sftp-credentials h3 {
            color: #856404;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sftp-credentials p {
            color: #856404;
            margin-bottom: 15px;
        }

        .credentials-display {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
            overflow-x: auto;
        }

        .credentials-display pre {
            margin: 0;
            color: #495057;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .note {
            font-style: italic;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .cat-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #f0f0f0;
            border-radius: 6px;
        }

        .cat-section h3 {
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cat-section p {
            color: #666;
            margin-bottom: 15px;
        }

        .cat-image {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-rocket"></i> My Webapp</h1>
            <p class="subtitle">Your Custom Web Application Skeleton</p>
        </div>

        <div class="content">
            <div class="info-message">
                <h2><i class="fas fa-check-circle"></i> Welcome to Your New Web Application!</h2>
                <p>Your YunoHost web application has been successfully installed and is ready for development. This is a powerful skeleton that supports multiple rewrite modes and modern web technologies.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-lock"></i></div>
                    <h3>SFTP Access</h3>
                    <p>Secure file transfer protocol access for easy file management and deployment.</p>
                </div>

                <div class="feature-card">
                    <div class="icon"><i class="fab fa-php"></i></div>
                    <h3>PHP Support</h3>
                    <p>Multiple PHP versions support with PHP-FPM for optimal performance.</p>
                </div>

                <div class="feature-card">
                    <div class="icon"><i class="fas fa-database"></i></div>
                    <h3>Database Ready</h3>
                    <p>Optional MySQL or PostgreSQL database integration with automatic backups.</p>
                </div>

                <div class="feature-card">
                    <div class="icon"><i class="fas fa-cogs"></i></div>
                    <h3>3 Rewrite Modes</h3>
                    <p>Choose between Default, Front Controller, or Framework patterns for your app.</p>
                </div>
            </div>

            <div class="php-info-section">
                <h3><i class="fas fa-code"></i> PHP Information</h3>
                <p>This page is generated by PHP and shows that your application is working correctly.</p>
                <p>Current PHP version: <strong><?php echo phpversion(); ?></strong></p>
                <p>Server software: <strong><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></strong></p>
                <p>Document root: <strong><?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown'; ?></strong></p>
            </div>

            <?php
            // Check if SFTP password file exists and display credentials
            $install_dir = dirname($_SERVER['DOCUMENT_ROOT']);
            $sftp_file = $install_dir . '/sftp_password.txt';
            if (file_exists($sftp_file) && is_readable($sftp_file)) {
                $sftp_content = file_get_contents($sftp_file);
                if ($sftp_content) {
                    echo '<div class="sftp-credentials">';
                    echo '<h3><i class="fas fa-key"></i> SFTP Credentials</h3>';
                    echo '<p>Your SFTP credentials are available in the file: <code>' . htmlspecialchars($sftp_file) . '</code></p>';
                    echo '<div class="credentials-display">';
                    echo '<pre>' . htmlspecialchars($sftp_content) . '</pre>';
                    echo '</div>';
                    echo '<p class="note"><i class="fas fa-info-circle"></i> You can delete this file after noting the information.</p>';
                    echo '</div>';
                }
            }
            ?>

            <div class="cat-section">
                <h3><i class="fas fa-cat"></i> As a reward, here is a random cat picture:</h3>
                <p>Take a break and enjoy this adorable cat!</p>
                <img src="https://thecatapi.com/api/images/get?format=src&type=gif" alt="Random Cat" class="cat-image">
            </div>

            <div class="status-badge">
                <i class="fas fa-check"></i> Application Successfully Installed and Running
            </div>

            <div class="footer">
                <p><i class="fas fa-rocket"></i> Powered by YunoHost • My Webapp Package v1.0</p>
                <p><i class="fas fa-lightbulb"></i> Ready to build something amazing!</p>
            </div>
        </div>
    </div>
</body>
</html>
