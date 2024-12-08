<!--
N.B.: README ini dibuat secara otomatis oleh <https://github.com/YunoHost/apps/tree/master/tools/readme_generator>
Ini TIDAK boleh diedit dengan tangan.
-->

# My Webapp untuk YunoHost

[![Tingkat integrasi](https://apps.yunohost.org/badge/integration/my_webapp)](https://ci-apps.yunohost.org/ci/apps/my_webapp/)
![Status kerja](https://apps.yunohost.org/badge/state/my_webapp)
![Status pemeliharaan](https://apps.yunohost.org/badge/maintained/my_webapp)

[![Pasang My Webapp dengan YunoHost](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=my_webapp)

*[Baca README ini dengan bahasa yang lain.](./ALL_README.md)*

> *Paket ini memperbolehkan Anda untuk memasang My Webapp secara cepat dan mudah pada server YunoHost.*  
> *Bila Anda tidak mempunyai YunoHost, silakan berkonsultasi dengan [panduan](https://yunohost.org/install) untuk mempelajari bagaimana untuk memasangnya.*

## Ringkasan

This application allows you to easily install an "empty" web application, in which you deploy your own custom website in the form of "static" HTML/CSS/JS assets or PHP.

Files can be uploaded [via SFTP](https://yunohost.org/en/filezilla) or any other method of your chosing.

During installation, you can also chose to initialize a MySQL or PostgreSQL database, which will be backed up and restored just like the other files in your application. The connection details will be stored in the file `db_access.txt` located in the root directory of the app.

PHP-FPM version can also be selected among (none), `7.4`, `8.0`, `8.1`, `8.2` and `8.3`.

**Once installed, go to the chosen URL to know the user, domain and port you will have to use for the SFTP access.** The password is the one specified during the installation. Under the app directory, you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom web application inside.

You can also customize 404 errors - if you enable the option in the config panel. Simply create an `error` folder in the `www` root directory, containing your custom `html` files. 


**Versi terkirim:** 1.0~ynh19
## Dokumentasi dan sumber daya

- Gudang YunoHost: <https://apps.yunohost.org/app/my_webapp>
- Laporkan bug: <https://github.com/YunoHost-Apps/my_webapp_ynh/issues>

## Info developer

Silakan kirim pull request ke [`testing` branch](https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing).

Untuk mencoba branch `testing`, silakan dilanjutkan seperti:

```bash
sudo yunohost app install https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
atau
sudo yunohost app upgrade my_webapp -u https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
```

**Info lebih lanjut mengenai pemaketan aplikasi:** <https://yunohost.org/packaging_apps>
