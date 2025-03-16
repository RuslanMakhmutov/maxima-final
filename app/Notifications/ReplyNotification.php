<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Comment $reply)
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/posts/' . $this->reply->post_id . '#comment-' . $this->reply->id);

        return (new MailMessage)
            ->subject('Новый ответ на комментарий')
            ->greeting(__('mail.greeting', ['name' => $notifiable->name])) // можно использовать переводы
            ->line('Появился новый ответ на Ваш комментарий')
            ->action('Посмотреть', $url)
            ->line('Спасибо, что используете наше приложение!');
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
