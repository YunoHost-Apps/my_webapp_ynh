Custom Webapp
-------------

Empty application with SFTP access to the Web directory.

## Overview

This application allows you to easily install a custom Web application,
providing files access with SFTP. It can also create a MySQL database -
which will be backed up and restored with your application. The connection
details will be stored in the file `db_accesss.txt` located in the root
directory.

Once installed, go to the chosen URL to know the user, domain and port
you will have to use for the SFTP access - the password is one you give
at the installation. Under the Web directory, you will see a `www` folder
which is the public and served one. You can put all the files of your
custom Web application inside.

## Upgrade

Due to the SFTP access change, the upgrade can not be done from the last
`my_webapp` application - provided with YunoHost 2.2. You will have to remove
it first and install this new one, taking care of migrating your data.

### Save your files and the database

You will have to save the content of the `/var/www/my_webapp/files`
directory, either from the Web admin interface provided by the old app or
connecting to your server using SSH - or SFTP as `admin`.

If you've created a MySQL database, you can also migrate it since the new
version allows to manage it for you. To create a dump, you could either use
[phpMyAdmin](https://github.com/YunoHost-Apps/phpmyadmin_ynh) or connect to
your server and execute:
`mysqldump -u root -p$(cat /etc/yunohost/mysql --no-create-db "$dbname" > ./dump.sql`
(do not forget to replace `$dbname` by your database name).

### Restore your custom Webapp

When you've taken care of saving your files - and optionally your database,
you can remove the app and install this new one. You can set the same
settings as the previous installation.

To restore your files, connect to the Web directory using the SFTP account - as
described at the installation path - and put everything into the `www` directory.

If you have chosen to migrate your database too, open the file `db_access.txt`
to know the new database, user and password you will have to set in your app
configuration. You can restore the dump you've created earlier either using
[phpMyAdmin](https://github.com/YunoHost-Apps/phpmyadmin_ynh) or connect to
your server and execute:
`mysql -u "$dbuser" -p"$dbpass" "$dbname" < ./dump.sql`
(do not forget to replace `$dbuser`, `$dbpass` and `$dbname` with the values
given in the file).

### SFTP port ###

You may have change the SSH port as described 
[here (section "Modifier le port SSH"](https://yunohost.org/#/security_fr) ; 
then you should use this port to update your website with SFTP.

## Links

**YunoHost**: https://yunohost.org/
