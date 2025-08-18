# 🌐 My Webapp - Your Custom Web Application

This application allows you to easily install a **custom web application** where you can deploy your own website using HTML, CSS, JavaScript, or PHP files.

## ✨ Key Features

- **Easy Deployment**: Upload your files via SFTP or any method you prefer
- **Flexible Routing**: Choose between 3 routing modes (static, front, public)
- **Database Support**: Optional MySQL or PostgreSQL database with automatic backup
- **PHP Support**: Select from PHP versions 8.0 to 8.4, or none
- **Custom Error Pages**: Create personalized 404 error pages
- **SFTP Access**: Secure file transfer with automatic password fallback

## 🚀 Getting Started

1. **Install the app** and choose your preferences
2. **Upload your files** to the `www` folder via SFTP
3. **Access your website** at the chosen URL
4. **Customize** error pages and settings as needed

## 📁 File Structure

```
www/
├── index.html          # Your main page
├── css/               # Stylesheets
├── js/                # JavaScript files
├── images/            # Images and media
└── error/             # Custom error pages (optional)
```

## 🔐 SFTP Access

- **Username**: Same as your app name
- **Password**: The one you set during installation
- **Port**: Standard SSH port (usually 22)
- **Directory**: `www/` folder for public files

> **💡 Tip**: If you don't set a password during installation, the system will automatically use your current username as the password for convenience.

## 🎨 Customization Options

- **Routing Mode**: Choose how URLs are handled
- **PHP Version**: Select the PHP version that fits your needs
- **Database**: Add a database for dynamic content
- **Error Pages**: Create custom 404 and error pages

## 📚 Need Help?

- Check the admin documentation for detailed configuration
- Visit the YunoHost community for support
- Review the routing modes documentation for advanced usage 
