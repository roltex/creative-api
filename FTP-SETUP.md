# 🚀 Quick FTP Setup Guide

## Step 1: Prepare Files

1. **Install dependencies** (on your local machine):
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

2. **Create database file**:
   ```bash
   touch database/database.sqlite
   ```

## Step 2: Upload to Server

Upload **ALL files** to your hosting via FTP, maintaining the folder structure.

**Important**: Your web server's document root should point to the `public/` folder.

## Step 3: Configure on Server

### Create `.env` file

Create a `.env` file in the root directory with:

```env
APP_NAME="Creative Georgia"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://creative-api.buildweb.dev

APP_LOCALE=ka
APP_FALLBACK_LOCALE=en

DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

**Replace** `/absolute/path/to/database/database.sqlite` with the actual absolute path on your server.

### Set Permissions

Set these permissions via FTP client or SSH:

- `storage/` → **755**
- `bootstrap/cache/` → **755**
- `database/database.sqlite` → **664**

## Step 4: Run Setup Commands

Via SSH or hosting control panel terminal:

```bash
# Generate application key
php artisan key:generate

# Create database tables
php artisan migrate

# (Optional) Add initial data
php artisan db:seed

# Create storage link
php artisan storage:link

# Cache for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Step 5: Test

1. Visit: `https://creative-api.buildweb.dev/api/settings`
2. Should return JSON data
3. Admin panel: `https://creative-api.buildweb.dev/admin`

## ✅ Done!

Your backend is now live. Update your frontend to use:
- API URL: `https://creative-api.buildweb.dev/api`

---

**Need Help?** Check `storage/logs/laravel.log` for errors.

