Cette application vous permet d'installer facilement une application vide, dans laquelle vous pouvez déployer votre propre site web "statique" (HTML/CSS/JS) ou PHP.

Les fichiers être déposé [via SFTP](https://yunohost.org/fr/filezilla) ou toute autre méthode de votre choix.

Lors de l'installation, il est aussi possible d'initialiser une base de données MySQL ou PostgreSQL, qui sera sauvegardée et restaurée avec le reste de l'application. Les détails de connexion seront stockés dans le fichier `db_accesss.txt` situé dans le répertoire racine.

La version de PHP-FPM peut aussi être choisie, parmi (aucune), `7.4`, `8.0`, `8.1`, `8.2`, `8.3` et `8.4`.

**Une fois installée, rendez-vous sur l'URL choisie pour connaître l'utilisateur, le domaine et le port que vous devrez utiliser pour l'accès SFTP.** Le mot de passe est celui que vous avez choisi lors de l'installation. Sous le répertoire Web, vous verrez un dossier `www` qui contient les fichiers publics servis par cette application. Vous pouvez mettre tous les fichiers de votre application Web personnalisée à l'intérieur.

L'application vous permet aussi de gérer - si vous activez l'option dans le panneau de configuration - la gestion des erreurs 404, il vous suffit de créer un dossier `error` dans le répertoire racine `www` et d'y placer vos fichiers d'erreur `html` 
