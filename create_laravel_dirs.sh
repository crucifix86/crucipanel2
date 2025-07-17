#!/bin/bash

echo "📁 Creating all Laravel required directories..."

# Your panel path on VPS
PANEL_PATH="/var/www/html/panel"
cd $PANEL_PATH

# Create all required storage directories
echo "Creating storage directories..."
mkdir -p storage/app/public
mkdir -p storage/app/backups
mkdir -p storage/app/updates
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/testing
mkdir -p storage/framework/views
mkdir -p storage/logs

# Create bootstrap cache directory
echo "Creating bootstrap cache..."
mkdir -p bootstrap/cache

# Create .gitignore files to keep directories
echo "Creating .gitignore files..."
echo "*" > storage/app/public/.gitignore
echo "!.gitignore" >> storage/app/public/.gitignore

echo "*" > storage/framework/cache/.gitignore
echo "!.gitignore" >> storage/framework/cache/.gitignore

echo "*" > storage/framework/sessions/.gitignore
echo "!.gitignore" >> storage/framework/sessions/.gitignore

echo "*" > storage/framework/views/.gitignore
echo "!.gitignore" >> storage/framework/views/.gitignore

echo "*" > storage/logs/.gitignore
echo "!.gitignore" >> storage/logs/.gitignore

echo "*" > bootstrap/cache/.gitignore
echo "!.gitignore" >> bootstrap/cache/.gitignore

# Set ownership (adjust user if needed)
echo "Setting ownership..."
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache

# Set permissions
echo "Setting permissions..."
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

echo "✅ All directories created!"
echo ""
echo "Now run: php artisan storage:link"
echo "Then try accessing your site."