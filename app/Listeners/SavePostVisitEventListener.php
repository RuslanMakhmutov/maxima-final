<?php

namespace App\Listeners;

use App\Events\PostVisitEvent;
use App\Models\Visit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SavePostVisitEventListener
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
    public function handle(PostVisitEvent $event): void
    {
        $visit = new Visit([
            'user_id' => auth()->id(),
        ]);
        $event->post->visits()->save($visit);
    }
}
