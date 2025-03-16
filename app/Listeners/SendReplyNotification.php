<?php

namespace App\Listeners;

use App\Events\CommentStoredEvent;
use App\Notifications\ReplyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReplyNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentStoredEvent $event): void
    {
        if ($event->comment->parent_id) {
            $event->comment->parent->user->notify(new ReplyNotification($event->comment));
        }
    }
}
