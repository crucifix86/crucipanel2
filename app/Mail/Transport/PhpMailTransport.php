<?php

namespace App\Mail\Transport;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

class PhpMailTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        
        $to = implode(', ', array_map(
            fn($address) => $address->toString(),
            $email->getTo()
        ));
        
        $subject = $email->getSubject() ?? '';
        
        $headers = [];
        
        // Add From header
        if ($from = $email->getFrom()) {
            $fromAddress = $from[0]->toString();
            $headers[] = 'From: ' . $fromAddress;
            
            // Extract email for envelope sender
            if (preg_match('/<(.+)>/', $fromAddress, $matches)) {
                $envelopeFrom = $matches[1];
            } else {
                $envelopeFrom = $from[0]->getAddress();
            }
        }
        
        // Add Reply-To header
        if ($replyTo = $email->getReplyTo()) {
            $headers[] = 'Reply-To: ' . $replyTo[0]->toString();
        }
        
        // Add CC header
        if ($cc = $email->getCc()) {
            $headers[] = 'Cc: ' . implode(', ', array_map(
                fn($address) => $address->toString(),
                $cc
            ));
        }
        
        // Add custom headers
        foreach ($email->getHeaders()->all() as $header) {
            if (!in_array(strtolower($header->getName()), ['from', 'to', 'cc', 'bcc', 'reply-to', 'subject'])) {
                $headers[] = $header->toString();
            }
        }
        
        // Add MIME headers for HTML email
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=UTF-8';
        
        $headersString = implode("\r\n", $headers);
        
        // Get email body
        $body = $email->getHtmlBody() ?? $email->getTextBody() ?? '';
        
        // Send email using PHP mail() function
        // Use envelope sender if we have a from address
        if (isset($envelopeFrom)) {
            $result = @mail($to, $subject, $body, $headersString, '-f ' . $envelopeFrom);
        } else {
            $result = @mail($to, $subject, $body, $headersString);
        }
        
        if (!$result) {
            $error = error_get_last();
            $errorMessage = isset($error['message']) ? $error['message'] : 'Unknown error';
            
            // Log debugging info
            \Log::error('PHP mail() failed', [
                'to' => $to,
                'subject' => $subject,
                'error' => $errorMessage,
                'php_ini_sendmail_path' => ini_get('sendmail_path'),
                'php_ini_smtp' => ini_get('SMTP'),
                'php_ini_smtp_port' => ini_get('smtp_port'),
            ]);
            
            throw new \RuntimeException('Failed to send email using PHP mail() function: ' . $errorMessage);
        }
    }

    public function __toString(): string
    {
        return 'phpmail';
    }
}