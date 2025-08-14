# 🌐 My Webapp - Custom Web Application Skeleton

This application allows you to easily install a powerful web application skeleton with **3 rewrite modes**, in which you deploy your own custom website in the form of "static" HTML/CSS/JS assets or PHP.

## ✨ Key Features

- **🚀 3 Rewrite Modes**: Choose between Default, Front Controller, or Framework patterns
- **🔐 SFTP Access**: Secure file upload and management
- **🐘 PHP Support**: Multiple PHP versions (7.4 to 8.4) with PHP-FPM
- **🗄️ Database Support**: Optional MySQL or PostgreSQL integration
- **🚨 Custom Error Pages**: Personalized 403 and 404 error handling
- **⚡ Auto-generated Passwords**: SFTP passwords generated automatically if needed

## 📁 File Management

Files can be uploaded [via SFTP](https://yunohost.org/en/filezilla) or any other method of your choosing. The SFTP password is either the one you specify during installation or automatically generated for security.

## 🗄️ Database Integration

During installation, you can also choose to initialize a MySQL or PostgreSQL database, which will be backed up and restored just like the other files in your application. The connection details will be stored in the file `db_access.txt` located in the root directory of the app.

## 🐘 PHP Configuration

PHP-FPM version can be selected among (none), `7.4`, `8.0`, `8.1`, `8.2`, `8.3` and `8.4`. The `php` command will point to the selected version when using the app shell.

## 🎯 Rewrite Modes Explained

### 🌐 Default Mode
Standard web serving without special rewrite rules. Perfect for simple static websites and basic PHP applications.

### 🎯 Front Mode
Single entry point application where all requests are rewritten to `/index.php`. Ideal for modern PHP applications and SPA frameworks.

### 🏗️ Framework Mode
Framework-style application where all requests are rewritten to `/public/index.php`. Perfect for Laravel, Symfony, and similar frameworks.

## 🔧 Post-Installation

**Once installed, go to the chosen URL to know the user, domain and port you will have to use for the SFTP access.** The password is either the one specified during the installation or automatically generated. Under the app directory, you will see a `www` folder which contains the public files served by this app. You can put all the files of your custom web application inside.

## 🚨 Error Customization

You can also customize 404 and 403 errors - if you enable the option in the config panel. Simply create an `error` folder in the `www` root directory, containing your custom `html` files.

## 🔄 Configuration Changes

All settings can be modified after installation using `yunohost app config my_webapp`, including the rewrite mode, SFTP access, PHP version, and database configuration. 
