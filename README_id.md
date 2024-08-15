<!--
N.B.: README ini dibuat secara otomatis oleh <https://github.com/YunoHost/apps/tree/master/tools/readme_generator>
Ini TIDAK boleh diedit dengan tangan.
-->

# My Webapp untuk YunoHost

[![Tingkat integrasi](https://dash.yunohost.org/integration/my_webapp.svg)](https://ci-apps.yunohost.org/ci/apps/my_webapp/) ![Status kerja](https://ci-apps.yunohost.org/ci/badges/my_webapp.status.svg) ![Status pemeliharaan](https://ci-apps.yunohost.org/ci/badges/my_webapp.maintain.svg)

[![Pasang My Webapp dengan YunoHost](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=my_webapp)

*[Baca README ini dengan bahasa yang lain.](./ALL_README.md)*

> *Paket ini memperbolehkan Anda untuk memasang My Webapp secara cepat dan mudah pada server YunoHost.*  
> *Bila Anda tidak mempunyai YunoHost, silakan berkonsultasi dengan [panduan](https://yunohost.org/install) untuk mempelajari bagaimana untuk memasangnya.*

## Ringkasan

This application allows you to easily install a custom Web application, providing files access with [SFTP](https://yunohost.org/en/filezilla).

It can also create a MySQL or PostgreSQL database - which will be backed up and restored with your application. The connection details will be stored in the file `db_access.txt` located in the root directory.

PHP-FPM version can also be selected among `none`, `7.4`, `8.0`, `8.1` and `8.2`.

**Once installed, go to the chosen URL to know the user, domain and port you will have to use for the SFTP access.** The password is one you chosen during the installation. Under the Web directory, you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom Web application inside.

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
