<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - My Webapp</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        .header {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .nav {
            background: #333;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }
        .nav a:hover {
            text-decoration: underline;
        }
        .content {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
        }
        .contact-form {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        .submit-btn {
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📧 Contact - My Webapp</h1>
        <p>Contactez-nous pour toute question ou support</p>
    </div>

    <div class="nav">
        <a href="/">Accueil</a>
        <a href="/about">À propos</a>
        <a href="/contact">Contact</a>
    </div>

    <div class="content">
        <h2>Nous contacter</h2>
        
        <p>Cette page démontre une autre fonctionnalité du Front Controller : la gestion de multiples routes.</p>
        
        <div class="contact-form">
            <h3>Formulaire de contact</h3>
            <form method="post" action="/contact">
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Sujet :</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message :</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Envoyer le message</button>
            </form>
        </div>

        <h3>Informations de contact</h3>
        <ul>
            <li><strong>Email :</strong> contact@mywebapp.com</li>
            <li><strong>Téléphone :</strong> +33 1 23 45 67 89</li>
            <li><strong>Adresse :</strong> 123 Rue de l'Innovation, 75001 Paris</li>
        </ul>

        <h3>Horaires d'ouverture</h3>
        <ul>
            <li><strong>Lundi - Vendredi :</strong> 9h00 - 18h00</li>
            <li><strong>Samedi :</strong> 10h00 - 16h00</li>
            <li><strong>Dimanche :</strong> Fermé</li>
        </ul>

        <h3>Informations techniques :</h3>
        <ul>
            <li><strong>URL actuelle :</strong> <?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></li>
            <li><strong>Fichier chargé :</strong> <?php echo htmlspecialchars(__FILE__); ?></li>
            <li><strong>Méthode HTTP :</strong> <?php echo htmlspecialchars($_SERVER['REQUEST_METHOD']); ?></li>
            <li><strong>Timestamp :</strong> <?php echo date('Y-m-d H:i:s'); ?></li>
        </ul>
    </div>

    <div class="footer">
        <p>My Webapp - Page "Contact" générée dynamiquement</p>
    </div>
</body>
</html>
