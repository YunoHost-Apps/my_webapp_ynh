{% if database != 'none' %}

Here are information to log into the database:

- Type: `__DATABASE__`
- Database user: `__DB_USER__`
- Database name: `__DB_NAME__`
- Password: `__DB_PWD__`

{% endif %}

{% if with_sftp == 1 %}

## SFTP Access

You can access your application files via SFTP:

- **Host**: `__DOMAIN__`
- **Port**: `22` (default SSH port)
- **Username**: `__NAME__`
- **Password**: `__PASSWORD__`
- **Directory**: `__INSTALL_DIR__/www`

**Note**: If no SFTP password was provided during installation, the password is the same as the user who installed this application.

{% endif %}

## Application Information

- **URL**: `https://__DOMAIN____PATH__`
- **Rewrite Mode**: `__REWRITE_MODE__`
- **Install Directory**: `__INSTALL_DIR__`

## Rewrite Mode Details

{% if rewrite_mode == 'default' %}
**Default Mode**: Standard web serving without special rewrite rules. Files are served directly from the `www/` directory.
{% endif %}

{% if rewrite_mode == 'front' %}
**Front Mode**: Single entry point application. All requests are rewritten to `/index.php` (front controller pattern).
{% endif %}

{% if rewrite_mode == 'framework' %}
**Framework Mode**: Framework-style application. All requests are rewritten to `/public/index.php` (Laravel/Symfony style).
{% endif %}
