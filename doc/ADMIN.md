# My Webapp - Administration Guide 🛠️

Complete guide for managing your My Webapp installation, including file management, configuration, and troubleshooting.

## 📁 File Management

### SFTP Access (Recommended)

Get SFTP connection details by visiting your application URL after installation:

- **Host**: `__DOMAIN__`
- **Username**: `__ID__`
- **Password**: Password chosen during installation
- **Port**: 22 (default SSH port)

#### SFTP Clients

- **Windows/Mac/Linux**: [FileZilla](https://filezilla-project.org/)
- **Mac**: Built-in Finder (Go > Connect to Server)
- **Linux**: File manager with SFTP support

#### Password Management

**Important**: If you don't provide a password during installation when SFTP is enabled, a secure random password will be automatically generated. This password is displayed during installation and stored in your application settings.

To change your SFTP password or check if SFTP is enabled:
1. Go to YunoHost admin panel
2. Navigate to `Apps > My webapp > Configuration`
3. Modify SFTP settings as needed

**Note**: The generated password is cryptographically secure and 20 characters long. You can change it anytime through the configuration panel.

### Command Line Access

Starting from YunoHost v11.1.21, use:
```bash
sudo yunohost app shell __APP__
```

This gives you direct access as the application user. The `php` command will use the PHP version configured for your app.

## 📂 Content Management

### File Structure

- **Static Mode**: Place files directly in `__INSTALL_DIR__/www/`
- **Front Mode**: Place files in `__INSTALL_DIR__/www/` (routed through index.php)
- **Public Mode**: Place public files in `__INSTALL_DIR__/www/public/`

### Adding Content

1. Connect via SFTP or command line
2. Navigate to the appropriate directory based on your NGINX mode
3. Upload or create your web application files
4. Ensure proper file permissions (typically 644 for files, 755 for directories)

## ⚠️ Error Handling

### Custom Error Pages

Support for custom error handling for HTTP errors 403 (Forbidden) and 404 (Not Found):

1. Create an `error` folder in `__INSTALL_DIR__/www/error/`
2. Add your custom HTML files:
   - `403.html` for access denied errors
   - `404.html` for resource not found errors

### Error Page Features

- Fully customizable HTML content
- Support for CSS styling and JavaScript
- Responsive design recommendations
- Integration with your application theme

## 🌐 NGINX Configuration

### Mode-Specific Configurations

The application automatically generates NGINX configurations based on your selected mode:

- **Static**: Standard configuration with optional PHP support
- **Front**: Front controller pattern with enhanced security
- **Public**: Front controller with public directory separation

### Custom NGINX Modifications

To customize the NGINX configuration:

1. Edit files in `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/`
2. Ensure files have `.conf` extension
3. Test configuration validity: `nginx -t`
4. Reload NGINX: `systemctl reload nginx`

**Note**: Avoid modifying the main configuration files. Use the app-specific directory for customizations.

## 🔒 Security Considerations

### File Permissions

- Web files: 644 (readable by web server)
- Directories: 755 (executable by web server)
- Configuration files: 600 (owner only)

### Sensitive File Protection

The application automatically protects sensitive files:
- `.env`, `.json`, `.ini`, `.tpl` files are denied access
- Hidden directories (except `.well-known/`) are protected
- PHP files are processed securely through PHP-FPM

## 🔧 Configuration Management

### Changing NGINX Mode

To switch between NGINX modes after installation:

1. Go to YunoHost admin panel
2. Navigate to `Apps > My webapp > Configuration`
3. Select the desired NGINX mode
4. Apply changes

**Note**: Changing NGINX mode will update your configuration and may require file reorganization.

### PHP Version Management

To change PHP version:

1. Go to YunoHost admin panel
2. Navigate to `Apps > My webapp > Configuration`
3. Select the desired PHP version
4. Apply changes

**Note**: PHP version changes require application restart and may affect existing PHP code.

## 🚨 Troubleshooting

### Common Issues

**SFTP Connection Failed**
- Verify the domain and username are correct
- Check if SFTP is enabled in configuration
- Ensure the password is correct or check for auto-generated password

**PHP Not Working**
- Verify PHP version is selected in configuration
- Check NGINX configuration files
- Ensure PHP-FPM service is running

**File Upload Issues**
- Check file permissions (644 for files, 755 for directories)
- Verify disk space availability
- Check SFTP user permissions

### Logs and Debugging

Access application logs:
```bash
sudo yunohost app log __APP__
```

Check NGINX error logs:
```bash
sudo tail -f /var/log/nginx/error.log
```

Check PHP-FPM logs:
```bash
sudo tail -f /var/log/php__VERSION__-fpm.log
```

## 📚 Additional Resources

- [YunoHost Documentation](https://yunohost.org/docs)
- [NGINX Documentation](https://nginx.org/en/docs/)
- [PHP Documentation](https://www.php.net/docs.php)
- [SFTP Best Practices](https://en.wikipedia.org/wiki/SSH_File_Transfer_Protocol)
