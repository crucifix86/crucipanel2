#!/bin/bash

echo "🚨 Emergency Component Fix"

cd /home/doug/crucipanel2

# Clear ALL caches and compiled views
echo "🧹 Clearing everything..."
rm -rf bootstrap/cache/*
rm -rf storage/framework/cache/*
rm -rf storage/framework/views/*
rm -rf storage/framework/sessions/*
php artisan clear-compiled

# Remove problematic cache files
rm -f bootstrap/cache/compiled.php
rm -f bootstrap/cache/services.php
rm -f bootstrap/cache/packages.php

# Clear artisan caches without compiling views
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Regenerate composer autoload
echo "📦 Regenerating autoload..."
composer dump-autoload

# DON'T cache anything yet - let it run without caches first
echo "✅ Emergency fix applied!"
echo ""
echo "⚠️  DO NOT run any cache commands yet!"
echo "🌐 Try accessing your site now. If it works, then run:"
echo "    php artisan config:cache"
echo "    php artisan route:cache"