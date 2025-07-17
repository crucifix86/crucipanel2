#!/bin/bash

echo "🔧 Rebuilding Laravel for Admin Access..."

cd /var/www/html/panel

# 1. Regenerate autoload files
echo "📦 Regenerating autoload..."
composer dump-autoload

# 2. Clear any remaining cache files
echo "🧹 Clearing old caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Optimize for production
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Create storage link if needed
echo "🔗 Creating storage link..."
php artisan storage:link

# 5. Run any pending migrations (if safe)
echo "📊 Checking migrations..."
php artisan migrate:status

echo "✅ Rebuild complete!"
echo ""
echo "🌐 Try accessing your admin panel now at: /admin/dashboard"
echo ""
echo "If you still can't login, try:"
echo "  php artisan optimize:clear"
echo "  php artisan optimize"