Cette application vous permet d'installer facilement une application vide personnalisée, fourni un accès aux fichiers avec [SFTP](https://yunohost.org/fr/filezilla).

Elle peut également créer une base de données MySQL - qui sera sauvegardée et restaurée avec votre application. Les détails de connexion seront stockés dans le fichier `db_accesss.txt` situé dans le répertoire racine.

La version de PHP-FPM peut aussi être choisie, parmi 7.3, 7.4, 8.0, 8.1 et 8.2.

**Une fois installé, rendez-vous sur l'URL choisie pour connaître l'utilisateur, le domaine et le port que vous devrez utiliser pour l'accès SFTP.** Le mot de passe est celui que vous avez choisi lors de l'installation. Sous le répertoire Web, vous verrez un dossier `www` qui contient les fichiers publics servis par cette application. Vous pouvez mettre tous les fichiers de votre application Web personnalisée à l'intérieur.

Si vous voulez ajouter une configuration personnalisée de nginx, mettez-la dans `/etc/nginx/conf.d/votre_domaine.d/my_webapp.d/WHATEVER_NAME.conf` (assurez-vous que le fichier a l'extension `.conf`, et changez `my_webapp.d` en `my_webapp__xx.d` si vous voulez changer la configuration de la deuxième installation ou plus de my_webapp).
