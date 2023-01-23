<?php

namespace App\Notifications\Api\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

/**
 * Class UserNeedsPasswordReset.
 */
class RecoveryPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * UserNeedsPasswordReset constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(env('APP_NAME') . ': ' . __('strings.emails.auth.password_reset_subject'))
            ->line(__('strings.emails.auth.password_cause_of_email'))
            ->action(
                __('buttons.emails.auth.reset_password'),
                Config::get('app.projectDomain') . '/reset-password/' . $this->token
            )
            ->line(__('strings.emails.auth.password_if_not_requested'));
    }
}
