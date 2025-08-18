<?php
// Get current timestamp for cache busting
$timestamp = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webapp - Public Mode</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .logo {
            font-size: 3rem;
            color: #fa709a;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .subtitle {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .mode-badge {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .feature {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-5px);
        }

        .feature i {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .feature h3 {
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .feature p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .chat-container {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
            border: 2px dashed #dee2e6;
        }

        .chat-gif {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .info-box {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
        }

        .info-box h3 {
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .info-box ul {
            list-style: none;
            text-align: left;
        }

        .info-box li {
            margin: 10px 0;
            padding-left: 20px;
            position: relative;
        }

        .info-box li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #fff;
            font-weight: bold;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            margin: 20px 10px;
            box-shadow: 0 10px 20px rgba(250, 112, 154, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(250, 112, 154, 0.4);
        }

        .footer {
            margin-top: 30px;
            color: #666;
            font-size: 0.9rem;
        }

        .php-info {
            background: #fff3e0;
            color: #e65100;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 0.9rem;
        }

        .directory-info {
            background: #e8f5e8;
            color: #2e7d32;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #4caf50;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <i class="fas fa-folder-open"></i>
        </div>
        
        <div class="mode-badge">
            <i class="fas fa-folder"></i> Public Mode - Public Directory
        </div>
        
        <h1>Welcome to My Webapp!</h1>
        <p class="subtitle">
            Your custom web application is ready with <strong>Public Mode</strong> routing. 
            Files are served from the public directory with PHP fallback.
        </p>

        <div class="php-info">
            <i class="fas fa-code"></i> <strong>PHP Info:</strong> 
            Version <?php echo phpversion(); ?> | 
            Server: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?> | 
            Time: <?php echo date('Y-m-d H:i:s'); ?>
        </div>

        <div class="directory-info">
            <h3><i class="fas fa-folder"></i> Public Directory Structure</h3>
            <p>Your files are served from the <code>public/</code> directory. Static files are served directly, 
            while dynamic routes fall back to this PHP file.</p>
        </div>

        <div class="features">
            <div class="feature">
                <i class="fas fa-folder-open"></i>
                <h3>Public Mode</h3>
                <p>Files served from public/</p>
            </div>
            <div class="feature">
                <i class="fas fa-rocket"></i>
                <h3>Fast & Modern</h3>
                <p>Built with the latest web technologies</p>
            </div>
            <div class="feature">
                <i class="fas fa-code"></i>
                <h3>PHP Ready</h3>
                <p>Full PHP support enabled</p>
            </div>
        </div>

        <div class="chat-container">
            <h3><i class="fas fa-cat"></i> Random Cat GIF</h3>
            <img src="https://cataas.com/cat/gif" alt="Random Cat" class="chat-gif" id="catGif">
            <p style="margin-top: 15px; color: #666;">
                <i class="fas fa-sync-alt"></i> Click the image to get a new cat!
            </p>
        </div>

        <div class="info-box">
            <h3><i class="fas fa-info-circle"></i> Public Mode Features</h3>
            <ul>
                <li>Static files served from public/ directory</li>
                <li>Dynamic routes fall back to PHP</li>
                <li>Perfect for traditional web applications</li>
                <li>Easy file organization</li>
            </ul>
        </div>

        <div>
            <a href="#" class="cta-button" onclick="refreshCat()">
                <i class="fas fa-upload"></i> Start Building
            </a>
            <a href="#" class="cta-button" onclick="refreshCat()">
                <i class="fas fa-cog"></i> Configure
            </a>
        </div>

        <div class="footer">
            <p><i class="fas fa-heart"></i> Powered by YunoHost | <i class="fas fa-php"></i> PHP Mode</p>
        </div>
    </div>

    <script>
        function refreshCat() {
            const catGif = document.getElementById('catGif');
            catGif.src = 'https://cataas.com/cat/gif?' + new Date().getTime();
        }

        // Refresh cat every 30 seconds
        setInterval(refreshCat, 30000);

        // Add click event to cat image
        document.getElementById('catGif').addEventListener('click', refreshCat);
    </script>
</body>
</html>
