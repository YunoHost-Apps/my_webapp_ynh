# Guide Post-Installation

## Accès à la Base de Données (si configurée)

{% if database != 'none' %}

Votre base de données a été configurée avec succès avec les identifiants suivants :

- **Type** : `__DATABASE__`
- **Utilisateur** : `__DB_USER__`
- **Nom de la base** : `__DB_NAME__`
- **Mot de passe** : `__DB_PWD__`

Ces identifiants sont également stockés dans `db_access.txt` dans le répertoire racine de votre application pour référence future.

{% endif %}

## Prochaines Étapes

### 1. Accéder à Votre Application
Visitez l'URL de votre application pour voir la page d'accueil par défaut et les détails de connexion SFTP.

### 2. Choisir Votre Mode NGINX
Votre application est configurée avec le mode NGINX **`{{ nginx_mode }}`** :

- **Classic** : Service de fichiers standard (par défaut)
- **Rewrite** : Pattern front controller pour applications PHP modernes
- **Rewrite-Public** : Front controller avec séparation du répertoire public

### 3. Uploader Votre Contenu
Connectez-vous via SFTP en utilisant les identifiants affichés sur votre page d'application :
- **Hôte** : Votre domaine
- **Nom d'utilisateur** : `__ID__`
- **Mot de passe** : Le mot de passe défini lors de l'installation
- **Port** : 22

### 4. Structure des Fichiers
Selon votre mode NGINX, placez vos fichiers dans :
- **Classic/Rewrite** : répertoire `www/`
- **Rewrite-Public** : répertoire `www/public/`

### 5. Pages d'Erreur Personnalisées (Optionnel)
Pour activer les pages d'erreur personnalisées :
1. Allez dans le panneau d'administration YunoHost
2. Naviguez vers la configuration de votre app
3. Activez "Erreur personnalisée HTML"
4. Créez un dossier `error` dans votre répertoire web
5. Ajoutez des fichiers `403.html` et `404.html` personnalisés

## Configuration

Vous pouvez modifier les paramètres de votre application à tout moment via :
- **Panneau d'Administration YunoHost** : Applications > My Webapp > Configuration
- **Ligne de Commande** : `yunohost app config my_webapp`

## Support

Pour une aide supplémentaire :
- Consultez le panneau de configuration de l'application
- Consultez la documentation YunoHost
- Consultez le guide d'administration dans le dossier documentation
