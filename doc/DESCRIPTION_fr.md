# 🌐 My Webapp - Squelette d'Application Web Personnalisée

Cette application vous permet d'installer facilement un squelette d'application web puissant avec **3 modes de rewrite**, dans laquelle vous pouvez déployer votre propre site web "statique" (HTML/CSS/JS) ou PHP.

## ✨ Fonctionnalités Principales

- **🚀 3 Modes de Rewrite** : Choisissez entre Par Défaut, Contrôleur Frontal, ou Framework
- **🔐 Accès SFTP** : Upload et gestion sécurisée des fichiers
- **🐘 Support PHP** : Multiples versions PHP (7.4 à 8.4) avec PHP-FPM
- **🗄️ Support Base de Données** : Intégration optionnelle MySQL ou PostgreSQL
- **🚨 Pages d'Erreur Personnalisées** : Gestion personnalisée des erreurs 403 et 404
- **⚡ Mots de Passe Auto-générés** : Mots de passe SFTP générés automatiquement si nécessaire

## 📁 Gestion des Fichiers

Les fichiers peuvent être déposés [via SFTP](https://yunohost.org/fr/filezilla) ou toute autre méthode de votre choix. Le mot de passe SFTP est soit celui que vous spécifiez lors de l'installation, soit généré automatiquement pour la sécurité.

## 🗄️ Intégration Base de Données

Lors de l'installation, il est aussi possible d'initialiser une base de données MySQL ou PostgreSQL, qui sera sauvegardée et restaurée avec le reste de l'application. Les détails de connexion seront stockés dans le fichier `db_access.txt` situé dans le répertoire racine.

## 🐘 Configuration PHP

La version de PHP-FPM peut aussi être choisie, parmi (aucune), `7.4`, `8.0`, `8.1`, `8.2`, `8.3` et `8.4`. La commande `php` pointera vers la version sélectionnée lors de l'utilisation du shell de l'app.

## 🎯 Modes de Rewrite Expliqués

### 🌐 Mode Par Défaut
Service web standard sans règles de rewrite spéciales. Parfait pour les sites web statiques simples et les applications PHP basiques.

### 🎯 Mode Front
Application à point d'entrée unique où toutes les requêtes sont réécrites vers `/index.php`. Idéal pour les applications PHP modernes et les frameworks SPA.

### 🏗️ Mode Framework
Application style framework où toutes les requêtes sont réécrites vers `/public/index.php`. Parfait pour Laravel, Symfony et frameworks similaires.

## 🔧 Post-Installation

**Une fois installée, rendez-vous sur l'URL choisie pour connaître l'utilisateur, le domaine et le port que vous devrez utiliser pour l'accès SFTP.** Le mot de passe est soit celui que vous avez choisi lors de l'installation, soit généré automatiquement. Sous le répertoire Web, vous verrez un dossier `www` qui contient les fichiers publics servis par cette application. Vous pouvez mettre tous les fichiers de votre application Web personnalisée à l'intérieur.

## 🚨 Personnalisation des Erreurs

L'application vous permet aussi de gérer - si vous activez l'option dans le panneau de configuration - la gestion des erreurs 404 et 403, il vous suffit de créer un dossier `error` dans le répertoire racine `www` et d'y placer vos fichiers d'erreur `html`.

## 🔄 Changements de Configuration

Tous les paramètres peuvent être modifiés après l'installation en utilisant `yunohost app config my_webapp`, y compris le mode de rewrite, l'accès SFTP, la version PHP et la configuration de la base de données. 
