#!/bin/bash

echo "🔧 Manual Update Script for CruciPanel"
echo "This will manually pull the latest changes from GitHub"
echo ""

# Make sure we're in the right directory
cd /home/doug/crucipanel2

# Fetch latest changes
echo "📥 Fetching latest changes from GitHub..."
git fetch origin

# Reset to the latest release
echo "🔄 Updating to v2.1.98..."
git reset --hard v2.1.98

# Clear all Laravel caches
echo "🧹 Clearing all caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Update composer dependencies if needed
echo "📦 Updating dependencies..."
composer install --no-dev --optimize-autoloader

# Clear compiled files
echo "🗑️ Clearing compiled files..."
php artisan clear-compiled

# Regenerate caches
echo "🔄 Regenerating caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "✅ Manual update complete!"
echo "🌐 Your panel should now be accessible."