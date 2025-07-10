<?php

echo "Checking Postfix + PHP Mail Configuration...\n\n";

// Check if running as CLI
$isCLI = php_sapi_name() === 'cli';

// Check Postfix status
echo "1. Postfix Status:\n";
$postfixStatus = shell_exec('systemctl status postfix 2>&1');
if (strpos($postfixStatus, 'active (running)') !== false) {
    echo "✓ Postfix is running\n";
} else {
    echo "✗ Postfix is not running or not installed\n";
    echo "  Run: sudo systemctl start postfix\n";
}

// Check mail queue
echo "\n2. Mail Queue:\n";
$mailQueue = shell_exec('mailq 2>&1');
echo "Queue output: " . substr($mailQueue, 0, 200) . "\n";

// Check Postfix configuration
echo "\n3. Key Postfix Settings:\n";
$postfixConfig = [
    'myhostname' => shell_exec('postconf myhostname 2>&1'),
    'mydomain' => shell_exec('postconf mydomain 2>&1'),
    'myorigin' => shell_exec('postconf myorigin 2>&1'),
    'inet_interfaces' => shell_exec('postconf inet_interfaces 2>&1'),
    'inet_protocols' => shell_exec('postconf inet_protocols 2>&1'),
];

foreach ($postfixConfig as $key => $value) {
    echo trim($value) . "\n";
}

// Check PHP mail settings
echo "\n4. PHP Mail Configuration:\n";
echo "- sendmail_path: " . ini_get('sendmail_path') . "\n";
echo "- mail.add_x_header: " . ini_get('mail.add_x_header') . "\n";
echo "- mail.log: " . ini_get('mail.log') . "\n";

// Check mail logs
echo "\n5. Recent mail log entries:\n";
$logPaths = ['/var/log/mail.log', '/var/log/maillog'];
foreach ($logPaths as $logPath) {
    if (file_exists($logPath)) {
        echo "From $logPath:\n";
        $logs = shell_exec("tail -n 10 $logPath 2>&1");
        echo $logs . "\n";
        break;
    }
}

// Test sending with detailed headers
echo "\n6. Testing email send with full headers:\n";
$to = "test@example.com"; // CHANGE THIS
$subject = "Postfix PHP Test";
$message = "Test from " . gethostname();
$headers = "From: noreply@" . gethostname() . "\r\n";
$headers .= "Return-Path: noreply@" . gethostname() . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "X-PHP-Script: " . $_SERVER['SCRIPT_NAME'] . "\r\n";

// Additional envelope parameter for Postfix
$additional = "-f noreply@" . gethostname();

$result = mail($to, $subject, $message, $headers, $additional);
echo "Mail function result: " . ($result ? "TRUE" : "FALSE") . "\n";

// Check for common issues
echo "\n7. Common Issues Check:\n";

// Check if running as web user
if (!$isCLI) {
    $webUser = get_current_user();
    echo "- Running as user: $webUser\n";
    echo "  Make sure this user can send mail through Postfix\n";
}

// Check hostname resolution
$hostname = gethostname();
$ip = gethostbyname($hostname);
echo "- Hostname resolves to: $ip\n";
if ($ip === $hostname) {
    echo "  ⚠ Hostname doesn't resolve to an IP - this can cause mail delivery issues\n";
}

echo "\n8. Recommended Postfix settings for PHP mail:\n";
echo "Edit /etc/postfix/main.cf and ensure:\n";
echo "- myhostname = vmi2301977.contaboserver.net\n";
echo "- inet_interfaces = loopback-only\n";
echo "- inet_protocols = ipv4\n";
echo "- mynetworks = 127.0.0.0/8\n";