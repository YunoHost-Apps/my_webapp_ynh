This app is simply a blank web app skeleton : you are expected to add you own content (HTML, CSS, PHP, ...) inside `__INSTALL_DIR__/www/`. One way to do so is by using SFTP.

### Login using SFTP

Once installed, go to the chosen URL to know the username, domain and port you will have to use for the SFTP access. 

- Host: `__DOMAIN__`
- Username: `__ID__`
- Password: password chosen during installation
- Port: 22 (unless you changed the SSH port)

To connect, you'll need an SFTP app such as [Filezilla](https://filezilla-project.org/) for Windows, Mac or Linux. You can also use your default file manager on [Mac](https://support.apple.com/guide/mac-help/connect-mac-shared-computers-servers-mchlp1140/mac) or Linux.

#### Forgot your SFTP password?

If you forgot your SFTP password, you can change it in YunoHost's webadmin interface in `Apps > My webapp > My Webapp configuration`.
You can also check there that SFTP is enabled.

### Login using the command line

Starting YunoHost v11.1.21, you can run `sudo yunohost app shell __APP__` in the command line interface to log in as your app user.

The `php` command will point to the PHP version installed for the app.

### Adding or editing files

Once logged in, under the Web directory you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom Web application inside.

### 403 and 404 error handling

The web server configuration supports http error handling `403` and `404` (access denied and resource not found). Create an `error` folder at `__INSTALL_DIR__/www/error`, and put your `403.html` and `404.html` files in there.

### Customizing the nginx configuration

If you want to add tweak the nginx configuration for this app, it is recommended to edit `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/WHATEVER_NAME.conf` (ensure that the file has the `.conf` extension) and reload the nginx after making sure that the configuration is valid using `nginx -t`.
