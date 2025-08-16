# My Webapp - Post-Installation Guide 🎯

Complete guide for getting started with your My Webapp installation, including next steps and configuration options.

## 🚀 Getting Started

Your My Webapp installation is now complete! Here's what you need to know to get started:

### What's Ready

- ✅ Web application platform is running
- ✅ NGINX configuration is active
- ✅ PHP support is configured (if selected)
- ✅ Database is ready (if configured)
- ✅ SFTP access is available (if enabled)

### First Steps

1. **Visit your application URL** to see the welcome page
2. **Check SFTP details** displayed on the welcome page
3. **Upload your website files** using the provided credentials
4. **Customize your application** as needed

## 📁 File Upload

### SFTP Access (Recommended)

Use the SFTP credentials displayed on your welcome page:

- **Host**: Your domain
- **Username**: Your app ID
- **Password**: Your installation password (or auto-generated one)
- **Port**: 22

**Note**: If you didn't provide a password during installation, a secure random password was automatically generated for you.

### Alternative Methods

- **SSH/SCP**: Direct server access for advanced users
- **Web interface**: If available through your hosting provider
- **Other FTP clients**: Any SFTP-compatible client

## 🗄️ Database Access (If Configured)

If you selected a database during installation:

### Connection Details

Database connection information is stored in `db_access.txt` in your application directory. Access it via:

```bash
sudo yunohost app shell __APP__
cat db_access.txt
```

### Database Management

- **MySQL**: Use phpMyAdmin or command line tools
- **PostgreSQL**: Use pgAdmin or command line tools
- **Backups**: Automatic backup integration is active

## 🌐 NGINX Mode Considerations

### Static Mode (Default)

- **File location**: Upload files directly to `/www/`
- **Best for**: Traditional websites, static content
- **URLs**: Direct file access (e.g., `/about.html`)

### Front Mode

- **File location**: Upload files to `/www/`
- **Best for**: PHP applications, custom routing
- **URLs**: Clean URLs routed through `index.php`

### Public Mode

- **File location**: Upload public files to `/www/public/`
- **Best for**: Modern frameworks (Laravel, Symfony)
- **URLs**: Framework-managed routing

## ⚙️ Configuration Options

### Available Settings

Access these through the YunoHost admin panel:

- **NGINX Mode**: Switch between Static, Front, and Public
- **PHP Version**: Change PHP version if needed
- **SFTP Settings**: Enable/disable SFTP, change password
- **Database Settings**: Modify database configuration

### Changing Settings

1. Go to YunoHost admin panel
2. Navigate to `Apps > My webapp > Configuration`
3. Modify desired settings
4. Apply changes

**Note**: Some changes may require application restart.

## 🔒 Security Best Practices

### File Permissions

- **Files**: 644 (readable by web server)
- **Directories**: 755 (executable by web server)
- **Configuration**: 600 (owner only)

### Sensitive Files

The application automatically protects:
- `.env`, `.json`, `.ini`, `.tpl` files
- Hidden directories (except `.well-known/`)
- Configuration files outside web directory

### SFTP Security

- Use strong passwords
- Consider key-based authentication
- Monitor access logs
- Disable SFTP if not needed

## 📝 Customization

### Error Pages

Create custom error pages:

1. Create `error` folder in your web directory
2. Add `403.html` for access denied errors
3. Add `404.html` for not found errors
4. Customize with your design and branding

### NGINX Configuration

For advanced users:

1. Edit files in `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/`
2. Test configuration: `nginx -t`
3. Reload NGINX: `systemctl reload nginx`

**Warning**: Only modify files in the app-specific directory.

## 🚨 Troubleshooting

### Common Issues

**Files not displaying**
- Check file permissions
- Verify NGINX mode configuration
- Check application logs

**SFTP connection failed**
- Verify credentials
- Check if SFTP is enabled
- Ensure SSH service is running

**PHP not working**
- Verify PHP version selection
- Check PHP-FPM service status
- Review NGINX configuration

### Getting Help

- **Application logs**: `sudo yunohost app log __APP__`
- **NGINX logs**: `/var/log/nginx/error.log`
- **YunoHost documentation**: [yunohost.org/docs](https://yunohost.org/docs)
- **Community support**: YunoHost forums and chat

## 🎉 Next Steps

### Immediate Actions

1. **Upload your website files** using SFTP
2. **Test your application** by visiting your domain
3. **Customize error pages** if desired
4. **Configure additional settings** as needed

### Long-term Considerations

- **Regular backups**: Database and file backups are automatic
- **Security updates**: Keep YunoHost and your application updated
- **Performance monitoring**: Monitor resource usage
- **Content updates**: Regular content updates and maintenance

### Support Resources

- **YunoHost Documentation**: [yunohost.org/docs](https://yunohost.org/docs)
- **NGINX Documentation**: [nginx.org/en/docs/](https://nginx.org/en/docs/)
- **PHP Documentation**: [php.net/docs.php](https://www.php.net/docs.php)
- **Community Forums**: YunoHost community support

Your My Webapp installation is now ready for production use! 🚀
