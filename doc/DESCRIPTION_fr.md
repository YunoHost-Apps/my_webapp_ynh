Cette application vous permet d'installer facilement une application vide personnalisée, fourni un accès aux fichiers avec [SFTP](https://yunohost.org/fr/filezilla).

Elle peut également créer une base de données MySQL - qui sera sauvegardée et restaurée avec votre application. Les détails de connexion seront stockés dans le fichier `db_accesss.txt` situé dans le répertoire racine.

La version de PHP-FPM peut aussi être choisie, parmi 7.3, 7.4, 8.0, 8.1 et 8.2.

# Usage

## Connection avec SFTP

Une fois installée, rendez-vous sur l'URL choisie pour connaître le nom d'utilisateur, le domaine et le port que vous devrez utiliser pour l'accès SFTP. 

Par défaut, le nom d'utilisateur est `my_webapp` ou `my_webapp__2`, `my_webapp__3` et ainsi de suite. Le mot de passe est celui que vous avez choisi lors de l'installation. 

Pour vous connectez, vous devrez utiliser une application SFTP tel que [Filezilla](https://filezilla-project.org/) pour Windows, Mac ou Linux. Vous pouvez aussi directement utiliser votre gestionnaire de fichiers sous Linux ou [Mac](https://support.apple.com/guide/mac-help/connect-mac-shared-computers-servers-mchlp1140/mac).

## Ajouter ou modifier les fichiers

Après vous être connecté avec SFTP, sous le répertoire Web, vous verrez un dossier `www` qui contient les fichiers publics servis par cette application. Vous pouvez mettre tous les fichiers de votre application Web personnalisée à l'intérieur.

## Oublie du mot de passe SFTP

Si vous avez oublié votre mot de passe SFTP, vous pouvez le changer dans la webadmin de Yunohost dans Applications > Votre webapp > My Webapp configuration.

# Résolution de problèmes

Si vous n'arrivez pas à vous connecter et que vous avez vérifié que le nom d'utilisateur et le mot de passe sont bons, vérifiez si SFTP est activé pour votre app
