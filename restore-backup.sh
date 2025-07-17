#!/bin/bash

# CruciPanel2 Backup Restore Script
# This script helps restore the panel from a backup in case of update failure

echo "==================================="
echo "CruciPanel2 Backup Restore Utility"
echo "==================================="
echo ""

# Check if running from correct directory
if [ ! -f "artisan" ]; then
    echo "Error: This script must be run from the CruciPanel2 root directory"
    echo "Please cd to your panel directory and run: ./restore-backup.sh"
    exit 1
fi

# Check if PHP is available
if ! command -v php &> /dev/null; then
    echo "Error: PHP is not installed or not in PATH"
    exit 1
fi

# Run the backup restore command
php artisan backup:restore

# Check if restore was successful
if [ $? -eq 0 ]; then
    echo ""
    echo "✓ Backup restore completed successfully!"
    echo ""
    echo "Next steps:"
    echo "1. Clear your browser cache"
    echo "2. Check that the panel is working correctly"
    echo "3. If you see any errors, check the Laravel logs in storage/logs/"
else
    echo ""
    echo "✗ Backup restore failed!"
    echo "Please check the error messages above."
    echo ""
    echo "Manual restore steps:"
    echo "1. Navigate to storage/app/backups/"
    echo "2. Find the backup ZIP file you want to restore"
    echo "3. Extract it manually and copy the files back"
    echo "4. Run: php artisan config:cache"
    echo "5. Run: php artisan route:cache"
fi