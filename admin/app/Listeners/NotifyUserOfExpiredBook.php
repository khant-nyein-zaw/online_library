<?php

namespace App\Listeners;

use App\Events\BookExpired;
use App\Notifications\BookExpiredNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserOfExpiredBook
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BookExpired  $event
     * @return void
     */
    public function handle(BookExpired $event)
    {
        $book = $event->book;
        $user = $book->issuedBook->user;
        $user->notify(new BookExpiredNotification($book));
    }
}
