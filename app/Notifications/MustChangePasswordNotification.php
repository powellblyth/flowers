<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class MustChangePasswordNotification extends Notification
{
    use Queueable;
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    public $firstname;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $firstname)
    {
        $this->token     = $token;
        $this->firstname = $firstname;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (!empty($this->firstname)) {
            $greeting = "Hello " . $this->firstname . ",";
        } else {
            $greeting = "Hi There!";
        }

        return (new MailMessage)
            ->greeting($greeting)
            ->subject(Lang::getFromJson('UPDATE !!! Welcome to the PHS Entries and Membership system'))
            ->line(Lang::getFromJson('With apologies for problems occurring with our past email!  '))
            ->line(Lang::getFromJson('All new systems have teething troubles, and this is no exception. The links you received earlier only lasted 60 minutes, which was not our intention. As a result, we are slightly altering the instructions. In order to set your password..'))
            ->line(Lang::getFromJson('To reset your password, simply pretend that you have forgotten your password. Please go to this page and enter your email address as ' . $notifiable->email . ' (you can change it later)'))
            ->action(Lang::getFromJson('I am pretending to have \'Forgotten\' my password!'), url(config('app.url') . route('password.request', [], false)))
            ->line(Lang::getFromJson('You will receive another (!!!) email  that has a correct link to reset your password in it'))
            ->line(Lang::getFromJson('(original message follows)'))
            ->line(Lang::getFromJson('The Petersham Horticultural Society is delighted to have a brand new online entry system. '))
            ->line(Lang::getFromJson('We would love you to be the first to try it. On this system you can create your entries, and as time goes on, we hope to implement a system to allow you to pay online, and purchase membership. It\'s the Future!'))
            ->line(Lang::getFromJson('We hope you are still happy for us to contact you via Email - if this has changed please let us know'))
            ->line(Lang::getFromJson('Where multiple people (i.e. other members of your family!) appear to be at the same address, we have endeavoured to group you all together to be managed with a single username and password. Do let me know if I got it wrong.'))
            ->line(Lang::getFromJson('If you think you received this in error, please feel free to let us know by emailing enquiries@petershamhorticulturalsociety.org.uk'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
