<!--
N.B.: Questo README è stato automaticamente generato da <https://github.com/YunoHost/apps/tree/master/tools/readme_generator>
NON DEVE essere modificato manualmente.
-->

# My Webapp per YunoHost

[![Livello di integrazione](https://dash.yunohost.org/integration/my_webapp.svg)](https://dash.yunohost.org/appci/app/my_webapp) ![Stato di funzionamento](https://ci-apps.yunohost.org/ci/badges/my_webapp.status.svg) ![Stato di manutenzione](https://ci-apps.yunohost.org/ci/badges/my_webapp.maintain.svg)

[![Installa My Webapp con YunoHost](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=my_webapp)

*[Leggi questo README in altre lingue.](./ALL_README.md)*

> *Questo pacchetto ti permette di installare My Webapp su un server YunoHost in modo semplice e veloce.*  
> *Se non hai YunoHost, consulta [la guida](https://yunohost.org/install) per imparare a installarlo.*

## Panoramica

This application allows you to easily install a custom Web application, providing files access with [SFTP](https://yunohost.org/en/filezilla).

It can also create a MySQL database - which will be backed up and restored with your application. The connection details will be stored in the file `db_access.txt` located in the root directory.

PHP-FPM version can also be selected among `none`, `7.4`, `8.0`, `8.1` and `8.2`.

**Once installed, go to the chosen URL to know the user, domain and port you will have to use for the SFTP access.** The password is one you chosen during the installation. Under the Web directory, you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom Web application inside.


**Versione pubblicata:** 1.0~ynh15
## Documentazione e risorse

- Repository upstream del codice dell’app: <https://github.com/YunoHost-Apps/my_webapp_ynh>
- Store di YunoHost: <https://apps.yunohost.org/app/my_webapp>
- Segnala un problema: <https://github.com/YunoHost-Apps/my_webapp_ynh/issues>

## Informazioni per sviluppatori

Si prega di inviare la tua pull request alla [branch di `testing`](https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing).

Per provare la branch di `testing`, si prega di procedere in questo modo:

```bash
sudo yunohost app install https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
o
sudo yunohost app upgrade my_webapp -u https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
```

**Maggiori informazioni riguardo il pacchetto di quest’app:** <https://yunohost.org/packaging_apps>
