<?php

namespace App\Listeners;

use App\Events\CategoryVisitEvent;
use App\Models\Visit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveCategoryVisitEventListener
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
    public function handle(CategoryVisitEvent $event): void
    {
        if (!(request()->has('page'))) {
            $visit = new Visit([
                'user_id' => auth()->id(),
            ]);
            $event->category->visits()->save($visit);
        }
    }
}
