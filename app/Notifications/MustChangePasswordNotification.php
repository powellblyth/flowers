<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MustChangePasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Welcome to the PHS Entries and Membership system')
            ->line('We are emailing you because you indicated you are happy for us to retain your details, and since we have a brand spanking new entries system we would love you to be the first to try it.')
            ->line('Where multiple people are at the same address, we have endeavoured to group you all together, and are managed with a single username and password. Do let me know if I got it wrong.')
            ->line('However, in order to do this, you will need to set yourself a password. This password is for the head of the family or group, which will save a lot of data entry in the future I promise')
            ->line('All you need to do is follow the link below, set yourself a password, and Bob is your newly discovered relation.')
                    ->action('Set me a password!', url('/'))
                    ->line('Thank you for using our system');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
