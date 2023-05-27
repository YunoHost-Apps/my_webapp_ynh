Cette application vous permet d'installer facilement une application vide personnalisée, fourni un accès aux fichiers avec [SFTP](https://yunohost.org/fr/filezilla).

Elle peut également créer une base de données MySQL - qui sera sauvegardée et restaurée avec votre application. Les détails de connexion seront stockés dans le fichier `db_accesss.txt` situé dans le répertoire racine.

La version de PHP-FPM peut aussi être choisie, parmi `none`, `7.4`, `8.0`, `8.1` et `8.2`.

**Une fois installé, rendez-vous sur l'URL choisie pour connaître l'utilisateur, le domaine et le port que vous devrez utiliser pour l'accès SFTP.** Le mot de passe est celui que vous avez choisi lors de l'installation. Sous le répertoire Web, vous verrez un dossier `www` qui contient les fichiers publics servis par cette application. Vous pouvez mettre tous les fichiers de votre application Web personnalisée à l'intérieur.
