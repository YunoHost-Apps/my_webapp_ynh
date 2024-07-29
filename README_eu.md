<!--
Ohart ongi: README hau automatikoki sortu da <https://github.com/YunoHost/apps/tree/master/tools/readme_generator>ri esker
EZ editatu eskuz.
-->

# My Webapp YunoHost-erako

[![Integrazio maila](https://dash.yunohost.org/integration/my_webapp.svg)](https://ci-apps.yunohost.org/ci/apps/my_webapp/) ![Funtzionamendu egoera](https://ci-apps.yunohost.org/ci/badges/my_webapp.status.svg) ![Mantentze egoera](https://ci-apps.yunohost.org/ci/badges/my_webapp.maintain.svg)

[![Instalatu My Webapp YunoHost-ekin](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=my_webapp)

*[Irakurri README hau beste hizkuntzatan.](./ALL_README.md)*

> *Pakete honek My Webapp YunoHost zerbitzari batean azkar eta zailtasunik gabe instalatzea ahalbidetzen dizu.*  
> *YunoHost ez baduzu, kontsultatu [gida](https://yunohost.org/install) nola instalatu ikasteko.*

## Aurreikuspena

This application allows you to easily install a custom Web application, providing files access with [SFTP](https://yunohost.org/en/filezilla).

It can also create a MySQL or PostgreSQL database - which will be backed up and restored with your application. The connection details will be stored in the file `db_access.txt` located in the root directory.

PHP-FPM version can also be selected among `none`, `7.4`, `8.0`, `8.1` and `8.2`.

**Once installed, go to the chosen URL to know the user, domain and port you will have to use for the SFTP access.** The password is one you chosen during the installation. Under the Web directory, you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom Web application inside.

You can also customize 404 errors - if you enable the option in the config panel. Simply create an `error` folder in the `www` root directory, containing your custom `html` files. 


**Paketatutako bertsioa:** 1.0~ynh18
## Dokumentazioa eta baliabideak

- Jatorrizko aplikazioaren kode-gordailua: <https://github.com/YunoHost-Apps/my_webapp_ynh>
- YunoHost Denda: <https://apps.yunohost.org/app/my_webapp>
- Eman errore baten berri: <https://github.com/YunoHost-Apps/my_webapp_ynh/issues>

## Garatzaileentzako informazioa

Bidali `pull request`a [`testing` abarrera](https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing).

`testing` abarra probatzeko, ondorengoa egin:

```bash
sudo yunohost app install https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
edo
sudo yunohost app upgrade my_webapp -u https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
```

**Informazio gehiago aplikazioaren paketatzeari buruz:** <https://yunohost.org/packaging_apps>
