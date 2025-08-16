# My Webapp - Plateforme d'Application Web Personnalisée

Cette application fournit une plateforme flexible pour déployer des applications web personnalisées sur YunoHost. Elle prend en charge à la fois le contenu statique (HTML/CSS/JS) et les applications PHP dynamiques avec plusieurs modes de configuration NGINX.

## Fonctionnalités

- **Modes NGINX Multiples** : Choisissez entre les configurations Statique, Front et Public
- **Déploiement Flexible** : Support des fichiers statiques et des applications PHP
- **Accès SFTP** : Upload et gestion sécurisés des fichiers avec génération automatique de mot de passe
- **Support Base de Données** : Intégration optionnelle MySQL ou PostgreSQL
- **PHP-FPM** : Sélection parmi PHP 8.1, 8.2, 8.3 ou 8.4 (ou aucune)
- **Pages d'Erreur Personnalisées** : Gestion personnalisée des erreurs 404 et autres
- **Sauvegardes Automatiques** : Intégration des sauvegardes de base de données et de fichiers

## Modes de Configuration NGINX

### Mode Statique (Par Défaut)
- Configuration NGINX standard
- Service direct des fichiers depuis le répertoire `/www`
- Compatible avec les applications web traditionnelles

### Mode Front
- Pattern front controller
- Route toutes les requêtes via `index.php`
- Sécurité renforcée avec protection des fichiers sensibles
- Idéal pour les applications PHP modernes

### Mode Public
- Front controller avec séparation du répertoire public
- Sert depuis le répertoire `/www/public`
- Parfait pour Laravel, Symfony et autres frameworks modernes

## Installation et Utilisation

Lors de l'installation, vous pouvez configurer :
- Sélection du mode NGINX
- Version PHP (8.1, 8.2, 8.3, 8.4, ou aucune)
- Type de base de données (MySQL, PostgreSQL, ou aucune)
- Accès SFTP avec mot de passe personnalisé (généré automatiquement si aucun fourni)
- Support des pages d'erreur personnalisées

## Gestion des Fichiers

Les fichiers peuvent être uploadés via :
- Accès SFTP (recommandé)
- Toute autre méthode de transfert de fichiers de votre choix

L'application crée un répertoire `www` où vous pouvez placer les fichiers de votre application web. Pour le mode Public, utilisez le sous-répertoire `www/public`.

## Intégration Base de Données

Si vous sélectionnez une base de données lors de l'installation :
- Les détails de connexion sont stockés dans `db_access.txt`
- Intégration automatique des sauvegardes et restaurations
- Gestion sécurisée des identifiants

## Personnalisation

- **Pages d'Erreur** : Créez un dossier `error` dans `www` avec vos fichiers HTML personnalisés
- **Configuration** : Modifiez les paramètres via le panneau d'administration YunoHost
- **Mode NGINX** : Changez de mode après installation via le panneau de configuration

## Fonctionnalités de Sécurité

- Protection des fichiers sensibles (`.env`, `.json`, `.ini`, `.tpl`)
- Protection des répertoires cachés (sauf `.well-known/`)
- Accès SFTP sécurisé
- Conformité aux standards de sécurité YunoHost 
