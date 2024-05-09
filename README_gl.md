<!--
NOTA: Este README foi creado automáticamente por <https://github.com/YunoHost/apps/tree/master/tools/readme_generator>
NON debe editarse manualmente.
-->

# My Webapp para YunoHost

[![Nivel de integración](https://dash.yunohost.org/integration/my_webapp.svg)](https://dash.yunohost.org/appci/app/my_webapp) ![Estado de funcionamento](https://ci-apps.yunohost.org/ci/badges/my_webapp.status.svg) ![Estado de mantemento](https://ci-apps.yunohost.org/ci/badges/my_webapp.maintain.svg)

[![Instalar My Webapp con YunoHost](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=my_webapp)

*[Le este README en outros idiomas.](./ALL_README.md)*

> *Este paquete permíteche instalar My Webapp de xeito rápido e doado nun servidor YunoHost.*  
> *Se non usas YunoHost, le a [documentación](https://yunohost.org/install) para saber como instalalo.*

## Vista xeral

This application allows you to easily install a custom Web application, providing files access with [SFTP](https://yunohost.org/en/filezilla).

It can also create a MySQL or PostgreSQL database - which will be backed up and restored with your application. The connection details will be stored in the file `db_access.txt` located in the root directory.

PHP-FPM version can also be selected among `none`, `7.4`, `8.0`, `8.1` and `8.2`.

**Once installed, go to the chosen URL to know the user, domain and port you will have to use for the SFTP access.** The password is one you chosen during the installation. Under the Web directory, you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom Web application inside.

You can also customize 404 errors - if you enable the option in the config panel. Simply create an`error` folder in the `www` root directory, containing your custom `html` files. 

**Versión proporcionada:** 1.0~ynh17
## Documentación e recursos

- Repositorio de orixe do código: <https://github.com/YunoHost-Apps/my_webapp_ynh>
- Tenda YunoHost: <https://apps.yunohost.org/app/my_webapp>
- Informar dun problema: <https://github.com/YunoHost-Apps/my_webapp_ynh/issues>

## Info de desenvolvemento

Envía a túa colaboración á [rama `testing`](https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing).

Para probar a rama `testing`, procede deste xeito:

```bash
sudo yunohost app install https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
ou
sudo yunohost app upgrade my_webapp -u https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
```

**Máis info sobre o empaquetado da app:** <https://yunohost.org/packaging_apps>
