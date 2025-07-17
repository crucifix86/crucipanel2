#!/bin/bash

echo "🔄 Rebuilding Laravel..."

cd /home/doug/crucipanel2

# Regenerate the autoload files
echo "📦 Regenerating autoload..."
composer dump-autoload

# Generate application key if missing
echo "🔑 Checking application key..."
php artisan key:generate --show

# Create the required cache files (but don't cache routes/config yet)
echo "📁 Creating cache structure..."
touch bootstrap/cache/.gitignore

# Test if Laravel is working
echo "🧪 Testing Laravel..."
php artisan --version

echo "✅ Laravel rebuilt!"
echo ""
echo "🌐 Now try accessing your site through the web browser."
echo "   Laravel will automatically compile views on first access."
echo ""
echo "⚠️  If the site works, THEN run these commands to optimize:"
echo "   php artisan config:cache"
echo "   php artisan route:cache"