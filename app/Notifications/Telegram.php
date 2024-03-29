<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramLocation;

class Telegram extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ["telegram"];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram(object $notifiable)
    {
        $url = 'https://www.krkd.fun';

        return TelegramMessage::create()
            // Optional recipient user id.
            //->to($notifiable->telegram_user_id)
            // Markdown supported.
            ->content("hi\n");

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
