This application allows you to easily install a custom Web application, providing files access with [SFTP](https://yunohost.org/en/filezilla).

It can also create a MySQL database - which will be backed up and restored with your application. The connection details will be stored in the file `db_access.txt` located in the root directory.

PHP-FPM version can also be selected among 7.3, 7.4, 8.0, 8.1 and 8.2.

# Usage

## Login using SFTP

Once installed, go to the chosen URL to know the username, domain and port you will have to use for the SFTP access. 

The default username is `my_webapp` or `my_webapp__2`, `my_webapp__3` and so on. The password is the one you've chosen during the installation. 

To connect, you'll need an SFTP app such as [Filezilla](https://filezilla-project.org/) for Windows, Mac or Linux. You can also use your default file manager on [Mac](https://support.apple.com/guide/mac-help/connect-mac-shared-computers-servers-mchlp1140/mac) or Linux.

## Adding or editing files

Once logged in SFTP, under the Web directory, you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom Web application inside.

## Forgot your SFTP password?

If you forgot your SFTP password, you can change it in Yunohost's webadmin interface in Apps > My webapp > My Webapp configuration.
