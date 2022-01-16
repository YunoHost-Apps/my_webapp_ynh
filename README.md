# Custom Webapp for YunoHost

[![Integration level](https://dash.yunohost.org/integration/my_webapp.svg)](https://dash.yunohost.org/appci/app/my_webapp) ![](https://ci-apps.yunohost.org/ci/badges/my_webapp.status.svg) ![](https://ci-apps.yunohost.org/ci/badges/my_webapp.maintain.svg)  
[![Install Custom Webapp with YunoHost](https://install-app.yunohost.org/install-with-yunohost.png)](https://install-app.yunohost.org/?app=my_webapp)

*[Lire ce readme en français.](./README_fr.md)*

> *This package allow you to install Custom Webapp quickly and simply on a YunoHost server.  
If you don't have YunoHost, please see [here](https://yunohost.org/install) to know how to install and enjoy it.*

## Overview

This application allows you to easily install a custom Web application,
providing files access with [SFTP](https://yunohost.org/en/filezilla). It can also create a MySQL database -
which will be backed up and restored with your application. The connection
details will be stored in the file `db_accesss.txt` located in the root
directory.

PHP-FPM version can also be selected among 7.3, 7.4, and 8.0.

**Once installed, go to the chosen URL to know the user, domain and port 
you will have to use for the SFTP access.** The password is one you chosen
during the installation. Under the Web directory, you will see a `www` folder
which contains the public files served by this app. You can put all the files
of your custom Web application inside.

**Shipped version:** 1.0

## Additional information

#### SFTP port

You may have change the SSH port as described in this section: 
[Modify the SSH port](https://yunohost.org/en/security#modify-the-ssh-port); 
then you should use this port to update your website with SFTP.

## Links

 * YunoHost documentation for this app: https://yunohost.org/en/app_my_webapp
 * Report a bug: https://github.com/YunoHost-Apps/my_webapp_ynh/issues
 * YunoHost website: https://yunohost.org/

---

## Developers info

Please do your pull request to the [testing branch](https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing).

To try the testing branch, please proceed like that.
```
sudo yunohost app install https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
or
sudo yunohost app upgrade my_webapp -u https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
```
