# Post-Installation Guide

## Database Access (if configured)

{% if database != 'none' %}

Your database has been successfully configured with the following credentials:

- **Type**: `__DATABASE__`
- **Database User**: `__DB_USER__`
- **Database Name**: `__DB_NAME__`
- **Password**: `__DB_PWD__`

These credentials are also stored in `db_access.txt` in your application root directory for future reference.

{% endif %}

## Next Steps

### 1. Access Your Application
Visit your application URL to see the default welcome page and SFTP connection details.

### 2. Choose Your NGINX Mode
Your application is configured with the **`{{ nginx_mode }}`** NGINX mode:

- **Classic**: Standard file serving (default)
- **Rewrite**: Front controller pattern for modern PHP apps
- **Rewrite-Public**: Front controller with public directory separation

### 3. Upload Your Content
Connect via SFTP using the credentials displayed on your application page:
- **Host**: Your domain
- **Username**: `__ID__`
- **Password**: The password you set during installation
- **Port**: 22

### 4. File Structure
Based on your NGINX mode, place your files in:
- **Classic/Rewrite**: `www/` directory
- **Rewrite-Public**: `www/public/` directory

### 5. Custom Error Pages (Optional)
To enable custom error pages:
1. Go to YunoHost admin panel
2. Navigate to your app configuration
3. Enable "HTML Custom error"
4. Create an `error` folder in your web directory
5. Add custom `403.html` and `404.html` files

## Configuration

You can modify your application settings anytime through:
- **YunoHost Admin Panel**: Apps > My Webapp > Configuration
- **Command Line**: `yunohost app config my_webapp`

## Support

For additional help:
- Check the application configuration panel
- Review YunoHost documentation
- Consult the admin guide in the documentation folder
