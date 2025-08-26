# IOC Fuel Station Management System

## 🚀 Quick Start

1. **Upload all files** to your cPanel hosting
2. **Test the system** by visiting: `your-domain.com/IOC/system-check.php`
3. **Access the system** at: `your-domain.com/IOC/`

## 📁 Important Files

- `index.php` - Main application entry point
- `serve-static.php` - Static file server (handles CSS/JS when .htaccess fails)
- `system-check.php` - System health checker
- `.htaccess` - URL routing configuration
- `config/` - System configuration files
- `bower_components/` - Frontend libraries (jQuery, Bootstrap Material Design)

## 🔧 Static File Solution

This system uses a custom static file server to ensure CSS and JavaScript files load correctly on all cPanel hosting environments, even when .htaccess rules don't work properly.

All static files are served through: `serve-static.php?file=path/to/file`

## 🏥 Troubleshooting

If you encounter issues:

1. Run the system checker: `your-domain.com/IOC/system-check.php`
2. Check file permissions: Files=644, Directories=755
3. Clear browser cache (Ctrl+Shift+R)
4. Contact hosting support if mod_rewrite is not enabled

## 🎯 System Features

- Fuel stock management
- Client management
- Employee management
- Revenue tracking
- Car wash services
- Lubricant services
- Asset maintenance
- Transport management

## 📱 Browser Support

- Modern browsers with JavaScript enabled
- Mobile responsive design
- Bootstrap Material Design UI
