<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mails\BookAssignedToSectionMail;
use App\Models\Book;
use Illuminate\Support\Facades\Mail;
class SendBookAssignedMailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Book $book)
    {
    }

    public function handle(): void
    {
        $book = $this->book->load('section','publisher');

        if ($book->publisher?->email && $book->section) {
            Mail::to($book->publisher->email)->send(
                new BookAssignedToSectionMail($book)
            );
        }
    }
}
