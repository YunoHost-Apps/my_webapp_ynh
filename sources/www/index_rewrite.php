<?php
// Get server information
$domain = $_SERVER['HTTP_HOST'] ?? 'your-domain.com';
$app_id = basename(dirname($_SERVER['SCRIPT_NAME']));
$ssh_port = 22; // Default SSH port

// Check if we're in a subdirectory
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$is_subdir = $base_path !== '/';

// Get PHP version info
$php_version = PHP_VERSION;
$php_sapi = php_sapi_name();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webapp - Front Mode</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .mode-badge {
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 15px;
            display: inline-block;
        }

        .content {
            padding: 40px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 15px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }

        .section h3 {
            color: #34495e;
            font-size: 1.2rem;
            margin: 20px 0 10px 0;
        }

        .section p {
            margin-bottom: 15px;
            color: #555;
        }

        .sftp-details {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            border-left: 5px solid #3498db;
        }

        .sftp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .sftp-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .sftp-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sftp-value {
            color: #3498db;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .info-box {
            background: #e8f4fd;
            border: 1px solid #bee5eb;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .info-box h4 {
            color: #0c5460;
            margin-bottom: 10px;
        }

        .info-box ul {
            margin-left: 20px;
            color: #0c5460;
        }

        .info-box li {
            margin-bottom: 5px;
        }

        .code-block {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            margin: 15px 0;
            overflow-x: auto;
        }

        .cat-section {
            text-align: center;
            margin-top: 40px;
            padding: 30px;
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border-radius: 15px;
        }

        .cat-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .cat-image {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .server-info {
            background: #f1f2f6;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }

        .server-info h4 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .server-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .server-item {
            background: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e9ecef;
        }

        .server-label {
            font-size: 0.8rem;
            color: #7f8c8d;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .server-value {
            font-weight: 600;
            color: #2c3e50;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .sftp-grid, .server-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-check-circle"></i> It Works!</h1>
            <p>Congratulations! You have successfully installed My Webapp in Front Mode</p>
            <div class="mode-badge"><i class="fas fa-sync-alt"></i> Front Controller Mode</div>
        </div>

        <div class="content">
            <div class="section">
                <h2><i class="fas fa-rocket"></i> Front Mode Overview</h2>
                <p>Your application is running in <strong>Front Mode</strong>, which provides a modern front controller pattern for PHP applications.</p>
                
                <div class="info-box">
                    <h4>Front Mode Features:</h4>
                    <ul>
                        <li><strong>Front Controller</strong> - All requests route through index.php</li>
                        <li><strong>Clean URLs</strong> - SEO-friendly routing structure</li>
                        <li><strong>Enhanced Security</strong> - Protection for sensitive files</li>
                        <li><strong>Modern PHP Apps</strong> - Perfect for frameworks and custom routing</li>
                    </ul>
                </div>
            </div>

            <div class="section">
                <h2><i class="fas fa-folder-open"></i> SFTP Connection Details</h2>
                <p>Use these credentials to connect via SFTP and upload your website files:</p>
                
                <div class="sftp-details">
                    <div class="sftp-grid">
                        <div class="sftp-item">
                            <div class="sftp-label">Domain</div>
                            <div class="sftp-value"><?php echo htmlspecialchars($domain); ?></div>
                        </div>
                        <div class="sftp-item">
                            <div class="sftp-label">Port</div>
                            <div class="sftp-value"><?php echo $ssh_port; ?></div>
                        </div>
                        <div class="sftp-item">
                            <div class="sftp-label">Username</div>
                            <div class="sftp-value"><?php echo htmlspecialchars($app_id); ?></div>
                        </div>
                        <div class="sftp-item">
                            <div class="sftp-label">Password</div>
                            <div class="sftp-value">Your installation password</div>
                        </div>
                    </div>
                </div>

                <div class="info-box">
                    <h4><i class="fas fa-key"></i> Password Information</h4>
                    <p><strong>Important:</strong> If you didn't provide a password during installation, a secure random password was automatically generated for you. This password is displayed above and stored in your application settings.</p>
                    <p>The generated password is cryptographically secure and 20 characters long. You can change it anytime through the YunoHost configuration panel.</p>
                </div>

                <p><strong>Recommended SFTP Client:</strong> <a href="https://filezilla-project.org/download.php?type=client" target="_blank">FileZilla</a> (Free, cross-platform)</p>
            </div>

            <div class="section">
                <h2><i class="fas fa-folder-tree"></i> File Structure & Routing</h2>
                <p>In Front Mode, your application structure should be:</p>
                
                <div class="code-block">
                    /var/www/<?php echo htmlspecialchars($app_id); ?>/www/<br>
                    ├── index.php          # Main entry point<br>
                    ├── .htaccess         # URL rewriting rules<br>
                    ├── assets/           # CSS, JS, images<br>
                    ├── includes/         # PHP includes<br>
                    └── pages/            # Content pages
                </div>

                <h3>URL Routing</h3>
                <p>All URLs will be processed through your main <code>index.php</code> file, allowing you to create clean, SEO-friendly URLs:</p>
                
                <div class="info-box">
                    <h4>Example URLs:</h4>
                    <ul>
                        <li><code>/about</code> → routes to your about page</li>
                        <li><code>/blog/post-123</code> → routes to blog post</li>
                        <li><code>/api/users</code> → routes to API endpoint</li>
                    </ul>
                </div>
            </div>

            <div class="section">
                <h2><i class="fas fa-cog"></i> Server Information</h2>
                <div class="server-info">
                    <h4>Current Server Details:</h4>
                    <div class="server-grid">
                        <div class="server-item">
                            <div class="server-label">PHP Version</div>
                            <div class="server-value"><?php echo $php_version; ?></div>
                        </div>
                        <div class="server-item">
                            <div class="server-label">Server API</div>
                            <div class="server-value"><?php echo $php_sapi; ?></div>
                        </div>
                        <div class="server-item">
                            <div class="server-label">Document Root</div>
                            <div class="server-value"><?php echo htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="server-item">
                            <div class="server-label">Script Path</div>
                            <div class="server-value"><?php echo htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? 'N/A'); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cat-section">
                <h3><i class="fas fa-cat"></i> Random Cat GIF</h3>
                <p>As a reward for your successful installation, here's a random cat GIF:</p>
                <img src="https://thecatapi.com/api/images/get?format=src&type=gif" alt="Random Cat GIF" class="cat-image">
            </div>
        </div>
    </div>
</body>
</html>
