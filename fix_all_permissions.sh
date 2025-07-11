#!/bin/bash

echo "🚨 Emergency Permission Fix"

# Your actual panel path on the VPS
PANEL_PATH="/var/www/html/panel"

cd $PANEL_PATH

# Create all required directories
echo "📁 Creating required directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/testing
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set ownership to web server user (adjust if needed)
echo "👤 Setting ownership..."
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache

# Set permissions
echo "🔐 Setting permissions..."
sudo chmod -R 755 storage
sudo chmod -R 755 bootstrap/cache

# Make sure log file is writable
sudo touch storage/logs/laravel.log
sudo chown www-data:www-data storage/logs/laravel.log
sudo chmod 664 storage/logs/laravel.log

echo "✅ Permissions fixed!"
echo ""
echo "Now try accessing your site again."