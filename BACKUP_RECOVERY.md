# Backup and Recovery Guide for CruciPanel2

## Overview
CruciPanel2 automatically creates backups before each update to protect against update failures. This guide explains how to manage and restore from these backups.

## Automatic Backup System

### When Backups are Created
- A backup is automatically created before each panel update
- Backups are stored as ZIP files in `storage/app/backups/`
- Backup filename format: `backup_YYYY-MM-DD_HH-MM-SS.zip`

### What's Included in Backups
- `/app` directory (all application code)
- `/config` directory (all configuration files)
- `/database` directory (migrations and seeders)
- `/resources` directory (views, language files, etc.)
- `/routes` directory (all route files)
- `composer.json` and `composer.lock` files
- `.env` file (database credentials and settings)

### Automatic Cleanup
- After a successful update, old backups are automatically cleaned up
- By default, only the 2 most recent backups are kept
- This prevents disk space issues while maintaining recovery options

## Restoring from Backup

### Method 1: Using Artisan Command (Recommended)
```bash
# Navigate to your panel directory
cd /path/to/crucipanel2

# Run the restore command
php artisan backup:restore

# The command will:
# 1. List all available backups
# 2. Let you choose which backup to restore
# 3. Restore all files and directories
# 4. Clear and rebuild caches
# 5. Put site in maintenance mode during restore
```

### Method 2: Using the Restore Script
```bash
# Navigate to your panel directory
cd /path/to/crucipanel2

# Run the restore script
./restore-backup.sh
```

### Method 3: Manual Restore (Emergency)
If the artisan commands don't work:

```bash
# 1. Navigate to the backups directory
cd storage/app/backups/

# 2. List available backups
ls -la

# 3. Extract the backup you want
unzip backup_2024-01-15_14-30-45.zip -d /tmp/restore

# 4. Copy files back (from panel root directory)
cp -r /tmp/restore/app ./
cp -r /tmp/restore/config ./
cp -r /tmp/restore/database ./
cp -r /tmp/restore/resources ./
cp -r /tmp/restore/routes ./

# 5. Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 6. Rebuild caches
php artisan config:cache
php artisan route:cache

# 7. Fix permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

## Important Notes

### Database Preservation
- The restore process does NOT restore the `.env` file by default
- This preserves your current database connection settings
- If you need to restore `.env`, extract it manually from the backup

### Maintenance Mode
- During restore, the site is automatically put in maintenance mode
- It's brought back online after successful restore
- If restore fails, the site is still brought back online

### Permissions
- File permissions are automatically fixed after restore
- If you still have permission issues, run:
  ```bash
  chmod -R 755 storage/
  chmod -R 755 bootstrap/cache/
  chown -R www-data:www-data . # Adjust user as needed
  ```

## Backup Management Commands

### List Backups
```bash
php artisan backup:restore
# Don't enter a backup name, just view the list
```

### Clean Up Old Backups
```bash
# Keep only the 2 most recent backups (default)
php artisan backup:cleanup

# Keep the 5 most recent backups
php artisan backup:cleanup --keep=5
```

### Create Manual Backup
While the system creates automatic backups, you can trigger one manually through the admin panel's update section.

## Troubleshooting

### "No backups found" Error
- Check that `storage/app/backups/` directory exists
- Ensure backups were created during updates
- Check file permissions on the storage directory

### Restore Fails
- Ensure you have sufficient disk space
- Check PHP memory limit and execution time
- Try manual restore method
- Check Laravel log: `storage/logs/laravel.log`

### Site Shows Errors After Restore
1. Clear all caches again:
   ```bash
   php artisan optimize:clear
   php artisan config:cache
   ```
2. Check file permissions
3. Ensure database connection is working
4. Check error logs

## Best Practices

1. **Test Restores**: Periodically test the restore process in a staging environment
2. **Monitor Disk Space**: Ensure adequate space for backups
3. **External Backups**: Consider copying backups to external storage for critical installations
4. **Document Changes**: Keep notes about what triggered the need for restoration

## Emergency Contacts
If you cannot restore the panel:
1. Check the GitHub issues: https://github.com/crucifix86/crucipanel2/issues
2. Review recent releases for known issues
3. Consider reverting to a previous release if a specific update caused issues