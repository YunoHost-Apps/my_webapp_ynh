# Custom Webapp

[![Integration level](https://dash.yunohost.org/integration/my_webapp.svg)](https://dash.yunohost.org/appci/app/my_webapp)  
[![Install my_webapp with YunoHost](https://install-app.yunohost.org/install-with-yunohost.png)](https://install-app.yunohost.org/?app=my_webapp)


Empty application with SFTP access to the Web directory.

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

### SFTP port

You may have change the SSH port as described 
[here (section "Modifier le port SSH"](https://yunohost.org/#/security_fr) ; 
then you should use this port to update your website with SFTP.

## Links

**YunoHost**: https://yunohost.org/
