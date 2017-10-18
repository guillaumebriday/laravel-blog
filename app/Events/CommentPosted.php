<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use App\Http\Resources\Comment as CommentResource;
use App\Post;

class CommentPosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Comment details
     *
     * @var CommentResource
     */
    public $comment;

    /**
     * Post details
     *
     * @var Post
     */
    private $post;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CommentResource $comment, Post $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('post.' . $this->post->id);
    }

    /**
    * The event's broadcast name.
    *
    * @return string
    */
    public function broadcastAs()
    {
        return 'comment.posted';
    }
}
