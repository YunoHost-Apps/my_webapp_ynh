<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Webapp - Framework Mode</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #4ecdc4 100%);
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
            max-width: 700px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2d3748;
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header .subtitle {
            color: #718096;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .mode-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 15px 0;
        }

        .info-grid {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 20px;
            border-radius: 15px;
            border-left: 4px solid #ff6b6b;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            color: #2d3748;
            font-size: 1.1rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .info-card p {
            color: #4a5568;
            font-family: 'Courier New', monospace;
            background: #edf2f7;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            word-break: break-all;
        }

        .framework-info {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .framework-info h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .framework-info p {
            opacity: 0.9;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-block;
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 20px;
            text-align: center;
            width: 100%;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .info-grid {
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏗️ My Webapp</h1>
            <p class="subtitle">Framework Mode - Public Entry Point</p>
            <div class="mode-badge">Framework Mode Active</div>
        </div>

        <div class="framework-info">
            <h3>🎯 Framework Mode Information</h3>
            <p>This is the framework mode entry point. All requests are rewritten to this file, making it perfect for modern PHP frameworks like Laravel, Symfony, or custom MVC applications.</p>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>⏰ Current Time</h3>
                <p><?php echo date('Y-m-d H:i:s'); ?></p>
            </div>

            <div class="info-card">
                <h3>🌐 Request URI</h3>
                <p><?php echo $_SERVER['REQUEST_URI'] ?? 'N/A'; ?></p>
            </div>

            <div class="info-card">
                <h3>📝 Script Name</h3>
                <p><?php echo $_SERVER['SCRIPT_NAME'] ?? 'N/A'; ?></p>
            </div>

            <div class="info-card">
                <h3>🐘 PHP Version</h3>
                <p><?php echo PHP_VERSION; ?></p>
            </div>

            <div class="info-card">
                <h3>🖥️ Server Software</h3>
                <p><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'; ?></p>
            </div>
        </div>

        <div class="status-badge">
            ✅ Framework Mode Running Successfully
        </div>

        <div class="footer">
            <p>Powered by YunoHost • My Webapp Package • Framework Mode</p>
        </div>
    </div>
</body>
</html>
