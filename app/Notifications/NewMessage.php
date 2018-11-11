<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\User;

class NewMessage extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        // $this->fromUser = $user;
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
        if (property_exists($this->data, 'conversation')) {
            $receiver = User::findOrFail(last($this->data->conversation->messages)->sender_id);

            return (new MailMessage)
                        ->subject('You have a new message.')
                        ->line('You have new unread messages from '.$receiver->name.'.')
                        ->action('Read', url('/conversations/'.$this->data->conversation->id))
                        ->line('The is a Computer Generated Email.')
                        ->line('Please do not reply.')
                        ->line('But click the link.')
                        ->line('Thank you for using our application!');
        }
        return (new MailMessage)
                    ->subject('Welcome to the the Portal')
                    ->line('The is a computer Generated Email.')
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!')
                    ->markdown('mail.welcome.index', ['user' => $this->user]);
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
