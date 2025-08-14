# 🚀 My Webapp - Administration Guide

This app is a powerful web application skeleton with **3 rewrite modes** : you are expected to add your own content (HTML, CSS, PHP, ...) inside `__INSTALL_DIR__/www/`. One way to do so is by using SFTP.

## 🔐 SFTP Access

Once installed, go to the chosen URL to know the username, domain and port you will have to use for the SFTP access. 

- **Host**: `__DOMAIN__`
- **Username**: `__ID__`
- **Password**: password chosen during installation (or auto-generated)
- **Port**: 22 (unless you changed the SSH port)

To connect, you'll need an SFTP app such as [Filezilla](https://filezilla-project.org/) for Windows, Mac or Linux. You can also use your default file manager on [Mac](https://support.apple.com/guide/mac-help/connect-mac-shared-computers-servers-mchlp1140/mac) or Linux.

### 🔑 Forgot your SFTP password?

If you forgot your SFTP password, you can change it in YunoHost's webadmin interface in `Apps > My webapp > My Webapp configuration`.
You can also check there that SFTP is enabled.

## 💻 Command Line Access

Starting YunoHost v11.1.21, you can run `sudo yunohost app shell __APP__` in the command line interface to log in as your app user.

The `php` command will point to the PHP version installed for the app.

## 📁 Adding or Editing Files

Once logged in, under the Web directory you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom Web application inside.

## ⚙️ Rewrite Modes Configuration

Your app supports **3 different rewrite modes** that you can change anytime:

### 🌐 Default Mode
- **Purpose**: Standard web serving without special rewrite rules
- **Use Case**: Simple static websites, basic PHP applications
- **Behavior**: Files are served directly from the `www/` directory

### 🎯 Front Mode  
- **Purpose**: Single entry point application (front controller pattern)
- **Use Case**: Modern PHP applications, SPA frameworks
- **Behavior**: All requests are rewritten to `/index.php`

### 🏗️ Framework Mode
- **Purpose**: Framework-style applications (Laravel, Symfony, etc.)
- **Use Case**: Modern PHP frameworks with public directory
- **Behavior**: All requests are rewritten to `/public/index.php`

**To change the rewrite mode**: Use `yunohost app config my_webapp` and select your preferred mode.

## 🚨 Error Handling (403 and 404)

The web server configuration supports http error handling `403` and `404` (access denied and resource not found). Create an `error` folder at `__INSTALL_DIR__/www/error`, and put your `403.html` and `404.html` files in there.

## 🔧 Customizing Nginx Configuration

If you want to tweak the nginx configuration for this app, it is recommended to edit `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/WHATEVER_NAME.conf` (ensure that the file has the `.conf` extension) and reload nginx after making sure that the configuration is valid using `nginx -t`.

## 📊 Application Information

- **URL**: `https://__DOMAIN____PATH__`
- **Rewrite Mode**: `__REWRITE_MODE__`
- **Install Directory**: `__INSTALL_DIR__`
- **PHP Version**: `__PHPVERSION__` (if enabled)
- **Database**: `__DATABASE__` (if enabled)
