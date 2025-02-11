This application allows you to easily install an "empty" web application, in which you deploy your own custom website in the form of "static" HTML/CSS/JS assets or PHP.

Files can be uploaded [via SFTP](https://yunohost.org/en/filezilla) or any other method of your chosing.

During installation, you can also chose to initialize a MySQL or PostgreSQL database, which will be backed up and restored just like the other files in your application. The connection details will be stored in the file `db_access.txt` located in the root directory of the app.

PHP-FPM version can also be selected among (none), `7.4`, `8.0`, `8.1`, `8.2`, `8.3` and `8.4`.

**Once installed, go to the chosen URL to know the user, domain and port you will have to use for the SFTP access.** The password is the one specified during the installation. Under the app directory, you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom web application inside.

You can also customize 404 errors - if you enable the option in the config panel. Simply create an `error` folder in the `www` root directory, containing your custom `html` files. 
