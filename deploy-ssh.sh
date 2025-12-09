#!/bin/bash

# Deployment script for Creative Georgia Backend
# Usage: ./deploy-ssh.sh

SSH_HOST="u256849393@213.130.145.185"
SSH_PORT="65002"
REMOTE_PATH="/home/u256849393/domains/creative-api.buildweb.dev"

echo "🚀 Starting deployment to $SSH_HOST..."

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Please run this script from the Laravel root directory."
    exit 1
fi

echo "📦 Preparing files for deployment..."

# Create a temporary directory for files to upload
TEMP_DIR=$(mktemp -d)
echo "📁 Temporary directory: $TEMP_DIR"

# Copy all files except those in .gitignore
rsync -av --exclude-from=.gitignore \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='.env' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    ./ "$TEMP_DIR/"

echo "📤 Uploading files to server..."
scp -P $SSH_PORT -r "$TEMP_DIR"/* $SSH_HOST:$REMOTE_PATH/

echo "🧹 Cleaning up..."
rm -rf "$TEMP_DIR"

echo "✅ Files uploaded successfully!"
echo ""
echo "📝 Next steps on the server:"
echo "1. SSH into the server"
echo "2. cd $REMOTE_PATH"
echo "3. Create .env file"
echo "4. Run: php artisan key:generate"
echo "5. Run: php artisan migrate"
echo "6. Set permissions: chmod -R 755 storage bootstrap/cache"

