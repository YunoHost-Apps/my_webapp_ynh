# Custom Webapp for YunoHost

[![Integration level](https://dash.yunohost.org/integration/my_webapp.svg)](https://dash.yunohost.org/appci/app/my_webapp) ![](https://ci-apps.yunohost.org/ci/badges/my_webapp.status.svg) ![](https://ci-apps.yunohost.org/ci/badges/my_webapp.maintain.svg)  
[![Install Custom Webapp with YunoHost](https://install-app.yunohost.org/install-with-yunohost.png)](https://install-app.yunohost.org/?app=my_webapp)

> *This package allow you to install Custom Webapp quickly and simply on a YunoHost server.  
If you don't have YunoHost, please see [here](https://yunohost.org/#/install) to know how to install and enjoy it.*

## Overview

This application allows you to easily install a custom Web application,
providing files access with [SFTP](https://yunohost.org/#/filezilla). It can also create a MySQL database -
which will be backed up and restored with your application. The connection
details will be stored in the file `db_accesss.txt` located in the root
directory.

**Once installed, go to the chosen URL to know the user, domain and port 
you will have to use for the SFTP access.** The password is one you chosen
during the installation. Under the Web directory, you will see a `www` folder
which contains the public files served by this app. You can put all the files
of your custom Web application inside.

**Shipped version:** 1.0

## Screenshots

## Demo

## Configuration

## Documentation

 * YunoHost documentation: https://github.com/YunoHost/doc/blob/master/app_my_webapp.md

## YunoHost specific features

#### Multi-users support

#### Supported architectures

* x86-64b - [![Build Status](https://ci-apps.yunohost.org/ci/logs/my_webapp%20%28Apps%29.svg)](https://ci-apps.yunohost.org/ci/apps/my_webapp/)
* ARMv8-A - [![Build Status](https://ci-apps-arm.yunohost.org/ci/logs/my_webapp%20%28Apps%29.svg)](https://ci-apps-arm.yunohost.org/ci/apps/my_webapp/)

## Limitations

## Additional information

#### SFTP port

You may have change the SSH port as described 
[here (section "Modifier le port SSH"](https://yunohost.org/#/security_fr) ; 
then you should use this port to update your website with SFTP.

## Links

 * Report a bug: https://github.com/YunoHost-Apps/my_webapp_ynh/issues
 * YunoHost website: https://yunohost.org/

---

Developers info
----------------

**Only if you want to use a testing branch for coding, instead of merging directly into master.**
Please do your pull request to the [testing branch](https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing).

To try the testing branch, please proceed like that.
```
sudo yunohost app install https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
or
sudo yunohost app upgrade my_webapp -u https://github.com/YunoHost-Apps/my_webapp_ynh/tree/testing --debug
```
