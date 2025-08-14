Cette app est uniquement un squelette : il vous appartient d'ajouter vos propre pages HTML, CSS, PHP, ... à l'intérieur de `__INSTALL_DIR__/www/`. Une manière de procéder est d'utiliser SFTP.

### Connexion avec SFTP

Une fois installée, rendez-vous sur l'URL choisie pour connaître le nom d'utilisateur, le domaine et le port que vous devrez utiliser pour l'accès SFTP. 

- Hôte: `__DOMAIN__`
- Nom d'utilisateur: `__ID__`
- Mot de passe: mot de passe défini lors de l'installation
- Port: 22 (à moins que vous ayez changé le port SSH)

Pour vous connecter, vous devrez utiliser une application SFTP tel que [Filezilla](https://filezilla-project.org/) pour Windows, Mac ou Linux. Vous pouvez aussi directement utiliser votre gestionnaire de fichiers sous Linux ou [Mac](https://support.apple.com/guide/mac-help/connect-mac-shared-computers-servers-mchlp1140/mac).

#### Oubli du mot de passe SFTP

Si vous avez oublié votre mot de passe SFTP, vous pouvez le changer dans la webadmin de Yunohost dans `Applications > Votre webapp > My Webapp configuration`.
Vous pourrez aussi vérifier que SFTP est activé pour votre app.

### Connexion par le terminal

A partir de YunoHost v11.1.21, vous pouvez lancer `sudo yunohost app shell __APP__` dans un terminal pour vous connecter en tant que l'utilisateur gérant l'app.

La commande `php` pointera vers la version de PHP installée pour l'app.

### Ajouter ou modifier les fichiers

Après vous être connecté, sous le répertoire Web vous verrez un dossier `www` qui contient les fichiers publics servis par cette application. Vous pouvez mettre tous les fichiers de votre application Web personnalisée à l'intérieur.

### Gestion des erreurs 403 et 404

La configuration du serveur web prend en charge la gestion des erreurs http `403` et `404` (accès refusé et ressource non trouvée). Ajoutez un dossier `error` à l'emplacement `__INSTALL_DIR__/www/error`, puis ajoutez-y vos fichiers `403.html` et `404.html`.

### Personnaliser la configuration nginx

Si vous souhaitez ajuster la configuration nginx pour cette app, il est recommandé d'éditer `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/WHATEVER_NAME.conf` (assurez-vous que le fichier a l'extension `.conf`) puis rechargez nginx après vous être assuré que la configuration est valide à l'aide de `nginx -t`.
