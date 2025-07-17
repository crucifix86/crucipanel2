#!/bin/bash

echo "🔧 Fixing Laravel Permissions"

# Get the web server user (usually www-data, apache, or nginx)
WEB_USER="www-data"  # Change this if your web server uses a different user

# Set proper ownership for storage and bootstrap/cache
echo "Setting ownership to $WEB_USER..."
sudo chown -R $WEB_USER:$WEB_USER storage
sudo chown -R $WEB_USER:$WEB_USER bootstrap/cache

# Set proper permissions
echo "Setting permissions..."
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

# Make sure these directories exist
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions on the directories
sudo chmod -R 775 storage/framework
sudo chmod -R 775 storage/logs

# If you're running commands as your user, add yourself to the web server group
echo "Adding current user to web group..."
sudo usermod -a -G $WEB_USER $USER

echo "✅ Permissions fixed!"
echo ""
echo "If you still get errors, try:"
echo "  sudo php artisan cache:clear"
echo "  sudo php artisan config:clear"
echo "  sudo php artisan view:clear"