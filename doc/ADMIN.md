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

### Customizing the nginx configuration

If you want to add tweak the nginx configuration for this app, it is recommended to edit `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/WHATEVER_NAME.conf` (ensure that the file has the `.conf` extension) and reload the nginx after making sure that the configuration is valid using `nginx -t`.

{% if nodeversion != 'none' %}

### Interfacing with NodeJS

A `package.json` should be available within the `/var/www/__APP__/www`. It is used to `npm install`, `npm run build` then `npm run start`. As such, it should at least define the dependencies and provide the `build` and `install` scripts.

You should then start a server in `/var/www/__APP__/www/index.js`.
It should listen on the port provided through the `PORT` environment with `process.env.PORT` or statically with __PORT__.

The server should reload its files after they change, but due to systemd's limitations, it only works for top level folders/files.
If your server does not display the right things, restart the `__APP__-nodejs` service.
{% endif %}
