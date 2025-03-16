<?php

namespace App\Events;

use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentStoredEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Comment $comment)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("post.{$this->comment->post_id}.comments"),
            new PrivateChannel("posts"),
        ];
    }

    // /**
    //  * Имя события.
    //  */
    // public function broadcastAs(): string
    // {
    //     return 'comment.created';
    // }

    /**
     * Данные для трансляции.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return CommentResource::make($this->comment)->resolve();
    }
}
