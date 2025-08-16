# My Webapp - Custom Web Application Platform

This application provides a flexible platform for deploying custom web applications on YunoHost. It supports both static content (HTML/CSS/JS) and dynamic PHP applications with multiple NGINX configuration modes.

## Features

- **Multiple NGINX Modes**: Choose between Classic, Rewrite, and Rewrite-Public configurations
- **Flexible Deployment**: Support for static files and PHP applications
- **SFTP Access**: Secure file upload and management with automatic password generation
- **Database Support**: Optional MySQL or PostgreSQL integration
- **PHP-FPM**: Select from PHP 8.1, 8.2, 8.3, or 8.4 (or none)
- **Custom Error Pages**: Personalized 404 and error handling
- **Automatic Backups**: Database and file backup integration

## NGINX Configuration Modes

### Classic Mode (Default)
- Standard NGINX configuration
- Direct file serving from `/www` directory
- Compatible with traditional web applications

### Rewrite Mode
- Front controller pattern
- Routes all requests through `index.php`
- Enhanced security with sensitive file protection
- Ideal for modern PHP applications

### Rewrite-Public Mode
- Front controller with public directory separation
- Serves from `/www/public` directory
- Perfect for Laravel, Symfony, and other modern frameworks

## Installation & Usage

During installation, you can configure:
- NGINX mode selection
- PHP version (8.1, 8.2, 8.3, 8.4, or none)
- Database type (MySQL, PostgreSQL, or none)
- SFTP access with custom password (auto-generated if none provided)
- Custom error page support

## File Management

Files can be uploaded via:
- SFTP access (recommended)
- Any other file transfer method of your choice

The application creates a `www` directory where you can place your web application files. For Rewrite-Public mode, use the `www/public` subdirectory.

## Database Integration

If you select a database during installation:
- Connection details are stored in `db_access.txt`
- Automatic backup and restore integration
- Secure credential management

## Customization

- **Error Pages**: Create an `error` folder in `www` with custom HTML files
- **Configuration**: Modify settings through the YunoHost admin panel
- **NGINX Mode**: Switch between modes after installation via configuration panel

## Security Features

- Sensitive file protection (`.env`, `.json`, `.ini`, `.tpl`)
- Hidden directory protection (except `.well-known/`)
- Secure SFTP access
- YunoHost security standards compliance 
