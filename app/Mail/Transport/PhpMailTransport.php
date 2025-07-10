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
            $headers[] = 'From: ' . $from[0]->toString();
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
        $result = mail($to, $subject, $body, $headersString);
        
        if (!$result) {
            throw new \RuntimeException('Failed to send email using PHP mail() function');
        }
    }

    public function __toString(): string
    {
        return 'phpmail';
    }
}