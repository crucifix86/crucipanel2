#!/bin/bash

echo "🔧 Fixing Component Error..."

cd /var/www/html/panel

# 1. Clear ALL compiled views manually
echo "🗑️ Removing all compiled views..."
rm -rf storage/framework/views/*

# 2. Clear bootstrap cache
echo "🗑️ Clearing bootstrap cache..."
rm -rf bootstrap/cache/*

# 3. Regenerate composer autoload without optimization first
echo "📦 Regenerating autoload (no optimization)..."
composer dump-autoload

# 4. Clear config without caching
echo "🧹 Clearing config..."
php artisan config:clear

# 5. Try to access a simple artisan command
echo "🧪 Testing artisan..."
php artisan --version

# 6. DO NOT run view:cache or optimize yet!
echo "✅ Basic fix applied!"
echo ""
echo "⚠️  DO NOT run any cache commands yet!"
echo ""
echo "🌐 Try accessing your site now."
echo "   If it works, THEN run:"
echo "   php artisan config:cache"
echo "   php artisan route:cache"
echo "   (But NOT view:cache)"

# Also check if the component exists
echo ""
echo "📁 Checking for app-layout component..."
if [ -f "resources/views/components/app-layout.blade.php" ]; then
    echo "✅ Found: resources/views/components/app-layout.blade.php"
elif [ -f "resources/views/components/hrace009/app-layout.blade.php" ]; then
    echo "✅ Found: resources/views/components/hrace009/app-layout.blade.php"
else
    echo "❌ Component file not found!"
    echo "   This might be why it's failing."
fi