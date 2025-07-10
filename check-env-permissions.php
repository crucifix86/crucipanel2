<?php

echo "Checking .env file permissions and write capability...\n\n";

$envPath = __DIR__ . '/.env';

// Check if .env exists
if (!file_exists($envPath)) {
    echo "✗ .env file does not exist at: $envPath\n";
    echo "  You need to copy .env.example to .env\n";
    exit(1);
}

echo "✓ .env file exists\n";

// Check file permissions
$perms = fileperms($envPath);
$permsOctal = substr(sprintf('%o', $perms), -4);
echo "File permissions: $permsOctal\n";

// Check ownership
$owner = posix_getpwuid(fileowner($envPath));
$group = posix_getgrgid(filegroup($envPath));
echo "Owner: " . $owner['name'] . " (UID: " . fileowner($envPath) . ")\n";
echo "Group: " . $group['name'] . " (GID: " . filegroup($envPath) . ")\n";

// Check current user
$currentUser = get_current_user();
$processUser = posix_getpwuid(posix_geteuid());
echo "\nCurrent script owner: $currentUser\n";
echo "Process running as: " . $processUser['name'] . " (UID: " . posix_geteuid() . ")\n";

// Check if writable
if (is_writable($envPath)) {
    echo "\n✓ .env file is writable by current user\n";
} else {
    echo "\n✗ .env file is NOT writable by current user\n";
    echo "  The web server user needs write permission to update .env\n";
}

// Check parent directory
$parentDir = dirname($envPath);
if (is_writable($parentDir)) {
    echo "✓ Parent directory is writable\n";
} else {
    echo "✗ Parent directory is NOT writable\n";
}

// Test actual write capability
echo "\nTesting actual write capability...\n";
$testKey = 'TEST_WRITE_' . time();
$envContent = file_get_contents($envPath);
$testContent = $envContent . "\n$testKey=test";

if (@file_put_contents($envPath, $testContent) !== false) {
    echo "✓ Successfully wrote to .env file\n";
    // Clean up test
    file_put_contents($envPath, $envContent);
} else {
    echo "✗ Failed to write to .env file\n";
    $error = error_get_last();
    if ($error) {
        echo "  Error: " . $error['message'] . "\n";
    }
}

// Suggest fix
echo "\nTo fix permission issues, run these commands on your VPS:\n";
echo "sudo chown www-data:www-data " . $envPath . "\n";
echo "sudo chmod 664 " . $envPath . "\n";
echo "\nReplace 'www-data' with your web server user if different.";