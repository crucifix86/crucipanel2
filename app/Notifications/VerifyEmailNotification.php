<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(config('pw-config.server_name', 'Haven Perfect World') . ' - Verify Your Email Address')
            ->greeting('Greetings, ' . $notifiable->name . '!')
            ->line('Welcome to ' . config('pw-config.server_name', 'Haven Perfect World') . '! Your journey into our mystical realm begins with verifying your email address.')
            ->line('Please click the button below to verify your email address and unlock full access to your account:')
            ->action('Verify Email Address', $verificationUrl)
            ->line('This verification link will expire in 60 minutes.')
            ->line('If you did not create an account, no further action is required.')
            ->salutation('May your adventures be legendary,')
            ->from(config('mail.from.address'), config('pw-config.server_name', 'Haven Perfect World'));
    }
}