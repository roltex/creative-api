#!/bin/bash

# Simple script to create SQLite database file
# Run this before deployment or on the server

echo "Creating SQLite database file..."

# Create database file
touch database/database.sqlite

# Set permissions (adjust as needed)
chmod 664 database/database.sqlite

echo "Database file created: database/database.sqlite"
echo "You can now run: php artisan migrate"

