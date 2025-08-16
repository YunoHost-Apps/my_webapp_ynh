# My Webapp - Administration Guide

This application provides a flexible web application platform where you can deploy your own custom content (HTML, CSS, PHP, etc.) in the `__INSTALL_DIR__/www/` directory.

## File Management

### SFTP Access (Recommended)

Once installed, visit your application URL to get the SFTP connection details:

- **Host**: `__DOMAIN__`
- **Username**: `__ID__`
- **Password**: Password chosen during installation
- **Port**: 22 (default SSH port)

#### SFTP Clients

- **Windows/Mac/Linux**: [FileZilla](https://filezilla-project.org/)
- **Mac**: Built-in Finder (Go > Connect to Server)
- **Linux**: File manager with SFTP support

#### Password Management

**Important**: If you don't provide a password during installation when SFTP is enabled, a secure random password will be automatically generated for you. This password will be displayed during the installation process and stored in the application settings.

To change your SFTP password or check if SFTP is enabled:
1. Go to YunoHost admin panel
2. Navigate to `Apps > My webapp > Configuration`
3. Modify SFTP settings as needed

**Note**: The generated password is cryptographically secure and 20 characters long. You can change it anytime through the configuration panel.

### Command Line Access

Starting from YunoHost v11.1.21, you can use:
```bash
sudo yunohost app shell __APP__
```

This gives you direct access as the application user. The `php` command will use the PHP version configured for your app.

## Content Management

### File Structure

- **Classic Mode**: Place files directly in `__INSTALL_DIR__/www/`
- **Rewrite Mode**: Place files in `__INSTALL_DIR__/www/` (routed through index.php)
- **Rewrite-Public Mode**: Place public files in `__INSTALL_DIR__/www/public/`

### Adding Content

1. Connect via SFTP or command line
2. Navigate to the appropriate directory based on your NGINX mode
3. Upload or create your web application files
4. Ensure proper file permissions (typically 644 for files, 755 for directories)

## Error Handling

### Custom Error Pages

The application supports custom error handling for HTTP errors 403 (Forbidden) and 404 (Not Found):

1. Create an `error` folder in `__INSTALL_DIR__/www/error/`
2. Add your custom HTML files:
   - `403.html` for access denied errors
   - `404.html` for resource not found errors

### Error Page Features

- Fully customizable HTML content
- Support for CSS styling and JavaScript
- Responsive design recommendations
- Integration with your application theme

## NGINX Configuration

### Mode-Specific Configurations

The application automatically generates NGINX configurations based on your selected mode:

- **Classic**: Standard configuration with optional PHP support
- **Rewrite**: Front controller pattern with enhanced security
- **Rewrite-Public**: Front controller with public directory separation

### Custom NGINX Modifications

To customize the NGINX configuration:

1. Edit files in `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/`
2. Ensure files have `.conf` extension
3. Test configuration validity: `nginx -t`
4. Reload NGINX: `systemctl reload nginx`

**Note**: Avoid modifying the main configuration files. Use the app-specific directory for customizations.

## Security Considerations

### File Permissions

- Web files: 644 (readable by web server)
- Directories: 755 (executable by web server)
- Sensitive files: 600 (owner only)

### Protected Resources

The application automatically protects:
- Configuration files (`.env`, `.json`, `.ini`, `.tpl`)
- Hidden directories (except `.well-known/`)
- System files outside the web directory

### SFTP Security

- Use strong passwords
- Consider key-based authentication
- Monitor access logs regularly
- Disable SFTP if not needed

## Troubleshooting

### Common Issues

1. **403 Forbidden**: Check file permissions and ownership
2. **404 Not Found**: Verify file paths and NGINX mode configuration
3. **SFTP Connection Failed**: Confirm credentials and SSH service status
4. **PHP Errors**: Check PHP version compatibility and configuration

### Logs

- **NGINX**: `/var/log/nginx/error.log`
- **PHP-FPM**: `/var/log/php__VERSION__-fpm.log`
- **Application**: Check YunoHost admin panel for app-specific logs

### Support

For additional help:
- Check YunoHost documentation
- Review application logs
- Consult the configuration panel
- Verify NGINX mode settings
