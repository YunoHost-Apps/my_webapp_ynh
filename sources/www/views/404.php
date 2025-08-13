<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - My Webapp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
            line-height: 1.6;
        }
        .error-container {
            background: #f8f8f8;
            padding: 40px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
        }
        .error-code {
            font-size: 72px;
            color: #e74c3c;
            margin: 0;
            font-weight: bold;
        }
        .error-message {
            font-size: 24px;
            color: #2c3e50;
            margin: 20px 0;
        }
        .error-description {
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        .back-link {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .back-link:hover {
            background: #2980b9;
        }
        .nav-links {
            margin-top: 30px;
        }
        .nav-links a {
            color: #7f8c8d;
            text-decoration: none;
            margin: 0 10px;
        }
        .nav-links a:hover {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Page non trouvée</h2>
        <p class="error-description">
            Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
        </p>
        
        <a href="/" class="back-link">Retour à l'accueil</a>
        
        <div class="nav-links">
            <a href="/about">À propos</a>
            <a href="/contact">Contact</a>
        </div>
    </div>
</body>
</html>
