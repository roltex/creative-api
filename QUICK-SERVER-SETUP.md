# 🚀 Quick Server Setup Guide

## SSH Access
```bash
ssh -p 65002 u256849393@213.130.145.185
# Password: Roltex112233$
```

## Server Path
```
/home/u256849393/domains/creative-api.buildweb.dev/public_html
```

## Quick Setup Steps

### 1. Connect to Server
```bash
ssh -p 65002 u256849393@213.130.145.185
```

### 2. Navigate to Application
```bash
cd /home/u256849393/domains/creative-api.buildweb.dev/public_html
```

### 3. Run Setup Script
```bash
# Make script executable
chmod +x server-setup.sh

# Run setup
./server-setup.sh
```

### OR Manual Setup:

#### 3a. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

#### 3b. Create .env File
```bash
cp .env.example .env
php artisan key:generate
```

#### 3c. Edit .env
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://creative-api.buildweb.dev
APP_LOCALE=ka

DB_CONNECTION=sqlite
DB_DATABASE=/home/u256849393/domains/creative-api.buildweb.dev/public_html/database/database.sqlite
```

#### 3d. Create Database
```bash
touch database/database.sqlite
chmod 664 database/database.sqlite
```

#### 3e. Set Permissions
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

#### 3f. Run Migrations
```bash
php artisan migrate --force
```

#### 3g. Create Storage Link
```bash
php artisan storage:link
```

#### 3h. Optimize
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## ⚠️ Important: Document Root Configuration

The web server's document root must point to:
```
/home/u256849393/domains/creative-api.buildweb.dev/public_html/public
```

NOT to `public_html` itself!

## 🧪 Testing

1. **Test API**: https://creative-api.buildweb.dev/api/settings
2. **Test Admin**: https://creative-api.buildweb.dev/admin
3. **Check Logs**: `tail -f storage/logs/laravel.log`

## 🔧 Troubleshooting

### Permission Errors
```bash
chmod -R 755 storage bootstrap/cache
chmod 664 database/database.sqlite
```

### Database Errors
```bash
# Check if database exists
ls -la database/database.sqlite

# Check permissions
chmod 664 database/database.sqlite
```

### Clear Cache
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Check PHP Version
```bash
php -v  # Should be 8.2+
```

### Check Required Extensions
```bash
php -m | grep -E "sqlite|pdo|mbstring|openssl|json"
```

## 📞 Support

Check logs: `storage/logs/laravel.log`

