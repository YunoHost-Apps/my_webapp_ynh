# My Webapp - Guide d'Administration

Cette application fournit une plateforme flexible d'application web où vous pouvez déployer votre propre contenu personnalisé (HTML, CSS, PHP, etc.) dans le répertoire `__INSTALL_DIR__/www/`.

## Gestion des Fichiers

### Accès SFTP (Recommandé)

Une fois installée, visitez l'URL de votre application pour obtenir les détails de connexion SFTP :

- **Hôte** : `__DOMAIN__`
- **Nom d'utilisateur** : `__ID__`
- **Mot de passe** : Mot de passe choisi lors de l'installation
- **Port** : 22 (port SSH par défaut)

#### Clients SFTP

- **Windows/Mac/Linux** : [FileZilla](https://filezilla-project.org/)
- **Mac** : Finder intégré (Aller > Se connecter au serveur)
- **Linux** : Gestionnaire de fichiers avec support SFTP

#### Gestion des Mots de Passe

**Important** : Si vous ne fournissez pas de mot de passe lors de l'installation alors que SFTP est activé, un mot de passe sécurisé aléatoire sera automatiquement généré pour vous. Ce mot de passe sera affiché pendant le processus d'installation et stocké dans les paramètres de l'application.

Pour changer votre mot de passe SFTP ou vérifier si SFTP est activé :
1. Allez dans le panneau d'administration YunoHost
2. Naviguez vers `Applications > My webapp > Configuration`
3. Modifiez les paramètres SFTP selon vos besoins

**Note** : Le mot de passe généré est cryptographiquement sécurisé et fait 20 caractères. Vous pouvez le changer à tout moment via le panneau de configuration.

### Accès en Ligne de Commande

À partir de YunoHost v11.1.21, vous pouvez utiliser :
```bash
sudo yunohost app shell __APP__
```

Cela vous donne un accès direct en tant qu'utilisateur de l'application. La commande `php` utilisera la version PHP configurée pour votre app.

## Gestion du Contenu

### Structure des Fichiers

- **Mode Classic** : Placez les fichiers directement dans `__INSTALL_DIR__/www/`
- **Mode Rewrite** : Placez les fichiers dans `__INSTALL_DIR__/www/` (routés via index.php)
- **Mode Rewrite-Public** : Placez les fichiers publics dans `__INSTALL_DIR__/www/public/`

### Ajout de Contenu

1. Connectez-vous via SFTP ou ligne de commande
2. Naviguez vers le répertoire approprié selon votre mode NGINX
3. Uploadez ou créez vos fichiers d'application web
4. Assurez-vous des bonnes permissions de fichiers (typiquement 644 pour les fichiers, 755 pour les répertoires)

## Gestion des Erreurs

### Pages d'Erreur Personnalisées

L'application prend en charge la gestion personnalisée des erreurs HTTP 403 (Interdit) et 404 (Non trouvé) :

1. Créez un dossier `error` dans `__INSTALL_DIR__/www/error/`
2. Ajoutez vos fichiers HTML personnalisés :
   - `403.html` pour les erreurs d'accès refusé
   - `404.html` pour les ressources non trouvées

### Fonctionnalités des Pages d'Erreur

- Contenu HTML entièrement personnalisable
- Support du style CSS et JavaScript
- Recommandations de design responsive
- Intégration avec le thème de votre application

## Configuration NGINX

### Configurations Spécifiques au Mode

L'application génère automatiquement des configurations NGINX selon votre mode sélectionné :

- **Classic** : Configuration standard avec support PHP optionnel
- **Rewrite** : Pattern front controller avec sécurité renforcée
- **Rewrite-Public** : Front controller avec séparation du répertoire public

### Modifications NGINX Personnalisées

Pour personnaliser la configuration NGINX :

1. Éditez les fichiers dans `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/`
2. Assurez-vous que les fichiers ont l'extension `.conf`
3. Testez la validité de la configuration : `nginx -t`
4. Rechargez NGINX : `systemctl reload nginx`

**Note** : Évitez de modifier les fichiers de configuration principaux. Utilisez le répertoire spécifique à l'application pour les personnalisations.

## Considérations de Sécurité

### Permissions des Fichiers

- Fichiers web : 644 (lisibles par le serveur web)
- Répertoires : 755 (exécutables par le serveur web)
- Fichiers sensibles : 600 (propriétaire uniquement)

### Ressources Protégées

L'application protège automatiquement :
- Fichiers de configuration (`.env`, `.json`, `.ini`, `.tpl`)
- Répertoires cachés (sauf `.well-known/`)
- Fichiers système en dehors du répertoire web

### Sécurité SFTP

- Utilisez des mots de passe forts
- Considérez l'authentification par clé
- Surveillez régulièrement les logs d'accès
- Désactivez SFTP si non nécessaire

## Dépannage

### Problèmes Courants

1. **403 Interdit** : Vérifiez les permissions et la propriété des fichiers
2. **404 Non trouvé** : Vérifiez les chemins de fichiers et la configuration du mode NGINX
3. **Échec de Connexion SFTP** : Confirmez les identifiants et le statut du service SSH
4. **Erreurs PHP** : Vérifiez la compatibilité de version PHP et la configuration

### Logs

- **NGINX** : `/var/log/nginx/error.log`
- **PHP-FPM** : `/var/log/php__VERSION__-fpm.log`
- **Application** : Consultez le panneau d'administration YunoHost pour les logs spécifiques à l'app

### Support

Pour une aide supplémentaire :
- Consultez la documentation YunoHost
- Examinez les logs de l'application
- Consultez le panneau de configuration
- Vérifiez les paramètres du mode NGINX
