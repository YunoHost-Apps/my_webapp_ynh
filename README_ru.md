<!--
Важно: этот README был автоматически сгенерирован <https://github.com/YunoHost/apps/tree/master/tools/readme_generator>
Он НЕ ДОЛЖЕН редактироваться вручную.
-->

# My Webapp для YunoHost

[![Уровень интеграции](https://apps.yunohost.org/badge/integration/my_webapp)](https://ci-apps.yunohost.org/ci/apps/my_webapp/)
![Состояние работы](https://apps.yunohost.org/badge/state/my_webapp)
![Состояние сопровождения](https://apps.yunohost.org/badge/maintained/my_webapp)

[![Установите My Webapp с YunoHost](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=my_webapp)

*[Прочтите этот README на других языках.](./ALL_README.md)*

> *Этот пакет позволяет Вам установить My Webapp быстро и просто на YunoHost-сервер.*  
> *Если у Вас нет YunoHost, пожалуйста, посмотрите [инструкцию](https://yunohost.org/install), чтобы узнать, как установить его.*

## Обзор

This application allows you to easily install an "empty" web application, in which you deploy your own custom website in the form of "static" HTML/CSS/JS assets or PHP.

Files can be uploaded [via SFTP](https://yunohost.org/en/filezilla) or any other method of your chosing.

During installation, you can also chose to initialize a MySQL or PostgreSQL database, which will be backed up and restored just like the other files in your application. The connection details will be stored in the file `db_access.txt` located in the root directory of the app.

PHP-FPM version can also be selected among (none), `7.4`, `8.0`, `8.1`, `8.2` and `8.3`.

**Once installed, go to the chosen URL to know the user, domain and port you will have to use for the SFTP access.** The password is the one specified during the installation. Under the app directory, you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom web application inside.

You can also customize 404 errors - if you enable the option in the config panel. Simply create an `error` folder in the `www` root directory, containing your custom `html` files. 


**Поставляемая версия:** 1.0~ynh19
## Документация и ресурсы

- Магазин YunoHost: <https://apps.yunohost.org/app/my_webapp>
- Сообщите об ошибке: <https://github.com/YunoHost-Apps/my_webapp_ynh/issues>

## Информация для разработчиков

Пришлите Ваш запрос на слияние в [ветку `testing`](https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing).

Чтобы попробовать ветку `testing`, пожалуйста, сделайте что-то вроде этого:

```bash
sudo yunohost app install https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
или
sudo yunohost app upgrade my_webapp -u https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
```

**Больше информации о пакетировании приложений:** <https://yunohost.org/packaging_apps>
