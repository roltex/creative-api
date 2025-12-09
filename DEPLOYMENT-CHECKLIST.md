# ✅ FTP Deployment Checklist

Use this checklist to ensure everything is ready for deployment.

## 📦 Pre-Deployment

- [ ] Run `composer install --optimize-autoloader --no-dev` locally
- [ ] Create `database/database.sqlite` file
- [ ] Test application locally
- [ ] Backup any existing data
- [ ] Review `.env` configuration

## 📤 Upload Files

- [ ] Upload all files via FTP maintaining directory structure
- [ ] Verify `public/` folder is set as document root
- [ ] Check that `.htaccess` files are uploaded

## ⚙️ Configuration

- [ ] Create `.env` file on server
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate `APP_KEY` using `php artisan key:generate`
- [ ] Configure `APP_URL` with your domain
- [ ] Set `DB_DATABASE` with absolute path to SQLite file
- [ ] Update CORS allowed origins in `config/cors.php`

## 🔐 Permissions

- [ ] Set `storage/` folder to 755 or 775
- [ ] Set `bootstrap/cache/` folder to 755 or 775
- [ ] Set `database/database.sqlite` to 664
- [ ] Verify `storage/app/public/` is writable
- [ ] Verify `storage/logs/` is writable

## 🗄️ Database

- [ ] Run `php artisan migrate` to create tables
- [ ] (Optional) Run `php artisan db:seed` to seed initial data
- [ ] Verify database file is accessible and writable
- [ ] Test database connection

## 🔗 Storage

- [ ] Run `php artisan storage:link` to create symbolic link
- [ ] Verify `public/storage` link exists
- [ ] Test file upload functionality

## 🚀 Optimization

- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Clear old cache: `php artisan cache:clear`

## 🧪 Testing

- [ ] Test API endpoints
- [ ] Test admin panel login
- [ ] Test file uploads
- [ ] Test database operations
- [ ] Check error logs: `storage/logs/laravel.log`

## 🔒 Security

- [ ] Verify `.env` is not publicly accessible
- [ ] Check that sensitive files are protected
- [ ] Verify CORS is configured correctly
- [ ] Test authentication endpoints

## 📝 Post-Deployment

- [ ] Update frontend API URL to production
- [ ] Test frontend-backend integration
- [ ] Monitor error logs
- [ ] Set up regular backups
- [ ] Document server-specific configurations

---

**Quick Commands Reference:**

```bash
# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Create storage link
php artisan storage:link

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

