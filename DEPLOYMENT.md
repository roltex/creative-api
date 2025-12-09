# 🚀 FTP Hosting Deployment Guide

This guide will help you deploy the Creative Georgia Backend to a standard FTP hosting provider.

## 📋 Prerequisites

- FTP access to your hosting server
- PHP 8.2 or higher
- SQLite support enabled
- mod_rewrite enabled (for Apache)
- Composer installed (for initial setup)

## 📁 File Structure on Server

Upload all files maintaining this structure:

```
public_html/ (or your web root)
├── app/
├── bootstrap/
├── config/
├── database/
│   └── database.sqlite (create this file)
├── public/ (this is your document root)
│   ├── .htaccess
│   ├── index.php
│   └── ...
├── resources/
├── routes/
├── storage/
│   ├── app/
│   │   ├── public/ (writable)
│   │   └── templates/ (writable)
│   ├── framework/
│   │   ├── cache/ (writable)
│   │   ├── sessions/ (writable)
│   │   └── views/ (writable)
│   └── logs/ (writable)
├── vendor/
├── .env
├── .htaccess (root level)
├── artisan
├── composer.json
└── composer.lock
```

## 🔧 Step-by-Step Deployment

### Step 1: Prepare Files Locally

1. **Install dependencies** (if not already done):
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

2. **Create database file**:
   ```bash
   touch database/database.sqlite
   ```

3. **Run migrations** (optional, can be done on server):
   ```bash
   php artisan migrate
   ```

### Step 2: Configure .env File

Create a `.env` file with these settings:

```env
APP_NAME="Creative Georgia"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://creative-api.buildweb.dev

APP_LOCALE=ka
APP_FALLBACK_LOCALE=en

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

FILESYSTEM_DISK=local
```

**Important**: 
- Generate APP_KEY: `php artisan key:generate`
- Use absolute path for DB_DATABASE (e.g., `/home/username/public_html/database/database.sqlite`)

### Step 3: Upload Files via FTP

1. **Upload all files** to your hosting server
2. **Set document root** to the `public/` folder
3. **Set permissions**:
   - `storage/` → 755 (or 775)
   - `bootstrap/cache/` → 755 (or 775)
   - `database/database.sqlite` → 664 (writable)

### Step 4: Configure Web Server

#### For Apache (.htaccess already included)

The `.htaccess` file in `public/` is already configured. Make sure:
- `mod_rewrite` is enabled
- `.htaccess` files are allowed

#### For Nginx

Add this configuration:

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
}

location ~ /\.(?!well-known).* {
    deny all;
}
```

### Step 5: Set Permissions

Via SSH (if available) or FTP client:

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 664 database/database.sqlite
```

### Step 6: Run Initial Setup

Via SSH or hosting control panel terminal:

```bash
# Generate application key (if not done locally)
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 7: Create Storage Link

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`.

## 🔒 Security Checklist

- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=production`
- [ ] `.env` file is not publicly accessible
- [ ] `storage/` and `bootstrap/cache/` are writable but not executable
- [ ] Database file has proper permissions (664)
- [ ] Remove any test/development files

## 📝 Important Notes

### SQLite Database

- The database file must be in a writable location
- Use absolute path in `.env`: `DB_DATABASE=/full/path/to/database.sqlite`
- Ensure the directory containing the database is writable
- Backup regularly: SQLite files can be easily copied

### File Uploads

- Uploaded files go to `storage/app/public/`
- Access via `public/storage/` (after running `php artisan storage:link`)
- Ensure `storage/app/public/` is writable

### CORS Configuration

Update `config/cors.php` with your frontend domain:

```php
'allowed_origins' => [
    'https://creative.buildweb.dev',
    'https://creative-georgia.ge',
    // Add your production domains
],
```

## 🐛 Troubleshooting

### 500 Internal Server Error

1. Check `storage/logs/laravel.log`
2. Verify file permissions
3. Check `.env` configuration
4. Ensure `APP_KEY` is set

### Database Errors

1. Verify SQLite path in `.env`
2. Check database file permissions
3. Ensure SQLite extension is enabled: `php -m | grep sqlite`

### Permission Denied

1. Set correct permissions on `storage/` and `bootstrap/cache/`
2. Check ownership of files
3. Some hosts require specific user/group ownership

### Routes Not Working

1. Verify `mod_rewrite` is enabled (Apache)
2. Check `.htaccess` file exists in `public/`
3. Verify document root points to `public/`

## 📞 Support

If you encounter issues:
1. Check `storage/logs/laravel.log`
2. Verify all requirements are met
3. Test with `php artisan about` command

---

**Last Updated**: December 2025
**Laravel Version**: 11.x
**PHP Requirement**: 8.2+

