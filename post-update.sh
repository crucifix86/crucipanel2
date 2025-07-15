#!/bin/bash

echo "Running post-update restoration..."

# Run the post-update command
php artisan update:post-restore

echo "Post-update completed!"