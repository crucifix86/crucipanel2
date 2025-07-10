<?php

// Test mail script for debugging email issues on VPS

// Basic PHP mail test
echo "Testing PHP mail configuration...\n\n";

// Check PHP mail configuration
echo "PHP Mail Configuration:\n";
echo "- sendmail_path: " . ini_get('sendmail_path') . "\n";
echo "- SMTP: " . ini_get('SMTP') . "\n";
echo "- smtp_port: " . ini_get('smtp_port') . "\n";
echo "- mail.log: " . ini_get('mail.log') . "\n\n";

// Test email parameters
$to = "your-email@example.com"; // CHANGE THIS to your test email
$subject = "Test Email from CruciPanel2";
$message = "This is a test email to verify PHP mail() function is working on the VPS.";
$headers = "From: noreply@" . gethostname() . "\r\n";
$headers .= "Reply-To: noreply@" . gethostname() . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

echo "Attempting to send test email to: $to\n\n";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Send test email
$result = mail($to, $subject, $message, $headers);

if ($result) {
    echo "✓ mail() function returned TRUE - Email queued for delivery\n\n";
    echo "Check your email inbox and spam folder.\n";
    echo "Also check mail logs:\n";
    echo "- /var/log/mail.log\n";
    echo "- /var/log/maillog\n";
    echo "- /var/log/syslog (grep for 'mail')\n";
} else {
    echo "✗ mail() function returned FALSE - Email failed\n\n";
    $error = error_get_last();
    if ($error) {
        echo "Last error: " . print_r($error, true) . "\n";
    }
}

// Check if sendmail/postfix is installed
echo "\nChecking mail system:\n";
$sendmail_paths = ['/usr/sbin/sendmail', '/usr/lib/sendmail', '/usr/bin/sendmail'];
foreach ($sendmail_paths as $path) {
    if (file_exists($path)) {
        echo "✓ Found sendmail at: $path\n";
    }
}

// Additional diagnostics
echo "\nAdditional diagnostics:\n";
echo "- PHP Version: " . phpversion() . "\n";
echo "- Server hostname: " . gethostname() . "\n";
echo "- Server IP: " . (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : gethostbyname(gethostname())) . "\n";