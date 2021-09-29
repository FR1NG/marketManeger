<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MarketCreated extends Notification
{
    use Queueable;

    protected $password;
    protected $market;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($password, $market, $user)
    {
        $this->password = $password;
        $this->market = $market;
        $this->user = $user;
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
            ->greeting('Bonjour ' . $this->user->name)
            ->subject('Création de marché en ' . env('APP_NAME', ''))
            ->line($this->market->name)
            ->action("connexion", url(config('app.url') . '/login'))
            ->line('Votre Email : ' . $this->user->email)
            ->line('Votre Mot De Pass : ' . $this->password)
            ->line('Merci d\'utiliser nos services');
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
