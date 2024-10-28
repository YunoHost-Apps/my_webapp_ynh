<!--
Nota bene : ce README est automatiquement généré par <https://github.com/YunoHost/apps/tree/master/tools/readme_generator>
Il NE doit PAS être modifié à la main.
-->

# My Webapp pour YunoHost

[![Niveau d’intégration](https://dash.yunohost.org/integration/my_webapp.svg)](https://ci-apps.yunohost.org/ci/apps/my_webapp/) ![Statut du fonctionnement](https://ci-apps.yunohost.org/ci/badges/my_webapp.status.svg) ![Statut de maintenance](https://ci-apps.yunohost.org/ci/badges/my_webapp.maintain.svg)

[![Installer My Webapp avec YunoHost](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=my_webapp)

*[Lire le README dans d'autres langues.](./ALL_README.md)*

> *Ce package vous permet d’installer My Webapp rapidement et simplement sur un serveur YunoHost.*  
> *Si vous n’avez pas YunoHost, consultez [ce guide](https://yunohost.org/install) pour savoir comment l’installer et en profiter.*

## Vue d’ensemble

Cette application vous permet d'installer facilement une application vide, dans laquelle vous pouvez déployer votre propre site web "statique" (HTML/CSS/JS) ou PHP.

Les fichiers être déposé [via SFTP](https://yunohost.org/fr/filezilla) ou toute autre méthode de votre choix.

Lors de l'installation, il est aussi possible d'initialiser une base de données MySQL ou PostgreSQL, qui sera sauvegardée et restaurée avec le reste de l'application. Les détails de connexion seront stockés dans le fichier `db_accesss.txt` situé dans le répertoire racine.

La version de PHP-FPM peut aussi être choisie, parmi (aucune), `7.4`, `8.0`, `8.1`, `8.2` et `8.3`.

**Une fois installée, rendez-vous sur l'URL choisie pour connaître l'utilisateur, le domaine et le port que vous devrez utiliser pour l'accès SFTP.** Le mot de passe est celui que vous avez choisi lors de l'installation. Sous le répertoire Web, vous verrez un dossier `www` qui contient les fichiers publics servis par cette application. Vous pouvez mettre tous les fichiers de votre application Web personnalisée à l'intérieur.

L'application vous permet aussi de gérer - si vous activez l'option dans le panneau de configuration - la gestion des erreurs 404, il vous suffit de créer un dossier `error` dans le répertoire racine `www` et d'y placer vos fichiers d'erreur `html` 


**Version incluse :** 1.0~ynh19
## Documentations et ressources

- YunoHost Store : <https://apps.yunohost.org/app/my_webapp>
- Signaler un bug : <https://github.com/YunoHost-Apps/my_webapp_ynh/issues>

## Informations pour les développeurs

Merci de faire vos pull request sur la [branche `testing`](https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing).

Pour essayer la branche `testing`, procédez comme suit :

```bash
sudo yunohost app install https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
ou
sudo yunohost app upgrade my_webapp -u https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
```

**Plus d’infos sur le packaging d’applications :** <https://yunohost.org/packaging_apps>
