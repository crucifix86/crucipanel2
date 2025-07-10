<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing .env update functionality...\n\n";

// Current .env values
echo "Current mail settings from .env:\n";
echo "MAIL_MAILER: " . env('MAIL_MAILER', 'not set') . "\n";
echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS', 'not set') . "\n";
echo "MAIL_FROM_NAME: " . env('MAIL_FROM_NAME', 'not set') . "\n\n";

// Test the updateEnvironmentFile method
$controller = new \App\Http\Controllers\Admin\SystemController();

// Use reflection to access protected method
$reflection = new ReflectionClass($controller);
$method = $reflection->getMethod('updateEnvironmentFile');
$method->setAccessible(true);

echo "Testing updateEnvironmentFile method...\n";

try {
    // Test update
    $testData = [
        'MAIL_MAILER' => 'mail',
        'MAIL_FROM_ADDRESS' => 'admin@crucifixpwi.net',
        'MAIL_FROM_NAME' => 'CrucifixPWI'
    ];
    
    $method->invoke($controller, $testData);
    
    echo "✓ Method executed without errors\n\n";
    
    // Re-read .env to check if it was updated
    $envContent = file_get_contents(base_path('.env'));
    echo "Checking if values were written:\n";
    
    foreach ($testData as $key => $value) {
        if (strpos($envContent, "$key=$value") !== false || strpos($envContent, "$key=\"$value\"") !== false) {
            echo "✓ $key was updated to: $value\n";
        } else {
            echo "✗ $key was NOT updated\n";
        }
    }
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n.env file path: " . base_path('.env') . "\n";
echo "Is writable: " . (is_writable(base_path('.env')) ? 'Yes' : 'No') . "\n";