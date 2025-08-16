# My Webapp - Custom Web Application Platform 🚀

A flexible platform for deploying custom web applications on YunoHost with multiple NGINX configuration modes and comprehensive features.

## ✨ Key Features

- **Multiple NGINX Modes**: Choose between Static, Front, and Public configurations
- **Flexible Deployment**: Support for static files and PHP applications  
- **SFTP Access**: Secure file upload with automatic password generation
- **Database Support**: Optional MySQL or PostgreSQL integration
- **PHP-FPM**: Select from PHP 8.1, 8.2, 8.3, or 8.4 (or none)
- **Custom Error Pages**: Personalized 404 and error handling
- **Automatic Backups**: Database and file backup integration

## 🌐 NGINX Configuration Modes

### Static Mode (Default)
Standard NGINX configuration for traditional web applications. Direct file serving from the `/www` directory with optional PHP support.

### Front Mode  
Front controller pattern that routes all requests through `index.php`. Enhanced security with sensitive file protection, perfect for modern PHP applications.

### Public Mode
Front controller with public directory separation. Serves from `/www/public` directory, ideal for Laravel, Symfony, and other modern frameworks.

## 🚀 Installation & Usage

During installation, configure:
- NGINX mode selection
- PHP version (8.1, 8.2, 8.3, 8.4, or none)
- Database type (MySQL, PostgreSQL, or none)
- SFTP access with custom password (auto-generated if none provided)
- Custom error page support

## 📁 File Management

Upload files via:
- SFTP access (recommended)
- Any other file transfer method

The application creates a `www` directory for your web application files. For Public mode, use the `www/public` subdirectory.

## 🗄️ Database Integration

If you select a database during installation:
- Connection details are stored in `db_access.txt`
- Automatic backup and restore integration
- Secure credential management

## ⚙️ Customization

- **Error Pages**: Create an `error` folder in `www` with custom HTML files
- **Configuration**: Modify settings through the YunoHost admin panel
- **NGINX Mode**: Switch between modes after installation via configuration panel

## 🔒 Security Features

- Sensitive file protection (`.env`, `.json`, `.ini`, `.tpl`)
- Hidden directory protection (except `.well-known/`)
- Secure SFTP access
- YunoHost security standards compliance 
