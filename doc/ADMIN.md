# 🛠️ Administration Guide - My Webapp

This app provides a **blank web application skeleton** where you can add your own content (HTML, CSS, PHP, etc.) inside the `__INSTALL_DIR__/www/` directory. The easiest way to add content is using SFTP.

## 🔐 SFTP Access

### Connection Details

Once installed, visit your app's URL to see the connection information:

- **Host**: `__DOMAIN__`
- **Username**: `__ID__`
- **Password**: The password you set during installation
- **Port**: 22 (standard SSH port)

> **💡 Password Tip**: If you didn't set a password during installation, the system automatically uses your current username as the password.

### SFTP Clients

You can connect using any SFTP client:

- **Windows/Mac/Linux**: [FileZilla](https://filezilla-project.org/)
- **Mac**: Built-in Finder (⌘+K)
- **Linux**: File manager or command line
- **Command Line**: `sftp __ID__@__DOMAIN__`
- **Default Path**: `/` (root of your domain)

### Forgot Your Password?

No worries! You can change your SFTP password anytime:

1. Go to **YunoHost Admin Panel**
2. Navigate to **Apps > My Webapp > Configuration**
3. Update your password in the SFTP section
4. Make sure SFTP is enabled

## 💻 Command Line Access

Starting from YunoHost v11.1.21, you can use:

```bash
sudo yunohost app shell __APP__
```

This gives you direct access as your app user, and the `php` command will use the PHP version installed for your app.

## 📁 Managing Your Files

### File Structure

```
__INSTALL_DIR__/www/
├── index.html          # Your main page
├── css/               # Stylesheets
├── js/                # JavaScript files
├── images/            # Images and media
└── error/             # Custom error pages
```

### Adding Content

1. **Connect via SFTP** using your credentials
2. **Navigate to the `www` folder**
3. **Upload your files** (HTML, CSS, JS, PHP, images, etc.)
4. **Your site is live** immediately!

## ⚠️ Error Handling

### Custom Error Pages

Create custom error pages for better user experience:

1. **Create an `error` folder** in `__INSTALL_DIR__/www/error/`
2. **Add your custom pages**:
   - `403.html` - Access denied
   - `404.html` - Page not found
3. **Enable the feature** in the app configuration panel

### Supported Error Codes

- **403**: Access Forbidden
- **404**: Page Not Found

## ⚙️ Advanced Configuration

### Nginx Customization

To customize the web server configuration:

1. **Edit files** in `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/`
2. **Use `.conf` extension** for your files
3. **Test configuration**: `nginx -t`
4. **Reload nginx**: `systemctl reload nginx`

### Routing Modes

Your app supports 3 routing modes:

- **Static**: Serves static files, falls back to index.php
- **Front**: Direct routing to index.php (SPA mode)
- **Public**: Serves from public directory

Change these in the configuration panel under "Routing Configuration".

## 🚀 Quick Start Checklist

- [ ] Install the app with your preferred settings
- [ ] Note your SFTP credentials from the app URL
- [ ] Connect via SFTP and upload your files
- [ ] Test your website
- [ ] Customize error pages (optional)
- [ ] Configure routing mode if needed

## 📚 Need More Help?

- **YunoHost Community**: [community.yunohost.org](https://community.yunohost.org)
- **Documentation**: Check the app description for basic usage
- **Routing Modes**: Review the test documentation for advanced configuration
