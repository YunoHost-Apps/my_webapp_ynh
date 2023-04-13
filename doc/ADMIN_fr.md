### Connexion avec SFTP

Une fois installée, rendez-vous sur l'URL choisie pour connaître le nom d'utilisateur, le domaine et le port que vous devrez utiliser pour l'accès SFTP. 

- Nom d'utilisateur: __ID__
- Mot de passe: mot de passe défini lors de l'installation
- Port: __SSH_PORT__

Pour vous connectez, vous devrez utiliser une application SFTP tel que [Filezilla](https://filezilla-project.org/) pour Windows, Mac ou Linux. Vous pouvez aussi directement utiliser votre gestionnaire de fichiers sous Linux ou [Mac](https://support.apple.com/guide/mac-help/connect-mac-shared-computers-servers-mchlp1140/mac).

### Ajouter ou modifier les fichiers

Après vous être connecté avec SFTP, sous le répertoire Web, vous verrez un dossier `www` qui contient les fichiers publics servis par cette application. Vous pouvez mettre tous les fichiers de votre application Web personnalisée à l'intérieur.

### Oubli du mot de passe SFTP

Si vous avez oublié votre mot de passe SFTP, vous pouvez le changer dans la webadmin de Yunohost dans `Applications > Votre webapp > My Webapp configuration`.

## Résolution de problèmes

Si vous n'arrivez pas à vous connecter et que vous avez vérifié que le nom d'utilisateur et le mot de passe sont bons, vérifiez si SFTP est activé pour votre app
