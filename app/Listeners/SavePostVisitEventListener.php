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
        $request = request();
        $visit = new Visit([
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'browser' => $request->userAgent(),
        ]);
        $event->post->visits()->save($visit);
    }
}
