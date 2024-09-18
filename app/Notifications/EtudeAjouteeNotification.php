<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Etude;

class EtudeAjouteeNotification extends Notification
{
    use Queueable;

    protected $etude;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Etude $etude)
    {
        $this->etude = $etude;
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
                    ->subject('Nouvelle étude ajoutée')
                    ->greeting('Bonjour,')
                    ->line('Une nouvelle étude a été ajoutée : '.$this->etude->title)
                    ->action('Voir l\'étude', url(route('catalogue.find', ['slug' => $this->etude->slug, 'etude' => $this->etude->id])))
                    ->line('Merci de votre attention.');
    }
}
