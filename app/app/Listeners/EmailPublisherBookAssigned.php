<?php

namespace App\Listeners;

use App\Events\BookSectionAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailPublisherBookAssigned
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
    public function handle(BookSectionAssigned $event): void
    {
        //
    }
}
