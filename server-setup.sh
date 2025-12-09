#!/bin/bash

# Server Setup Script for Creative Georgia Backend
# Run this on the server after uploading files

echo "🚀 Setting up Creative Georgia Backend..."

# Navigate to application directory
cd /home/u256849393/domains/creative-api.buildweb.dev/public_html || exit 1

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Please run this from the Laravel root directory."
    exit 1
fi

echo "✅ Found Laravel application"

# Install/Update Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# Create .env file if it doesn't exist
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
    
    # Generate application key
    php artisan key:generate --force
    
    # Update .env with production settings
    sed -i 's/APP_ENV=local/APP_ENV=production/' .env
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
    sed -i 's|APP_URL=http://localhost|APP_URL=https://creative-api.buildweb.dev|' .env
    sed -i 's/APP_LOCALE=en/APP_LOCALE=ka/' .env
    
    # Set database path
    DB_PATH="/home/u256849393/domains/creative-api.buildweb.dev/public_html/database/database.sqlite"
    sed -i "s|DB_DATABASE=.*|DB_DATABASE=$DB_PATH|" .env
    
    echo "✅ .env file created and configured"
else
    echo "ℹ️  .env file already exists"
fi

# Create database file if it doesn't exist
if [ ! -f "database/database.sqlite" ]; then
    echo "🗄️  Creating SQLite database..."
    touch database/database.sqlite
    chmod 664 database/database.sqlite
    echo "✅ Database file created"
else
    echo "ℹ️  Database file already exists"
fi

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 664 database/database.sqlite

# Run migrations
echo "🔄 Running database migrations..."
php artisan migrate --force

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# Clear and cache configuration
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "✅ Setup complete!"
echo ""
echo "📝 Next steps:"
echo "1. Verify document root points to: public_html/public"
echo "2. Test API: https://creative-api.buildweb.dev/api/settings"
echo "3. Test Admin: https://creative-api.buildweb.dev/admin"
echo ""
echo "🔍 Check logs: storage/logs/laravel.log"

