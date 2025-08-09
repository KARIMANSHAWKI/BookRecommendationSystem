<?php
namespace App\Jobs;

use App\Mails\NewBookAddedToAssignMail;
use App\Models\Book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifySectionManagersAboutNewBookJob implements ShouldQueue
{
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   public function __construct(
       public User $publisher,
       public Book $book
   ) {}

    public function handle(): void
    {
        // stream recipients to avoid loading all into memory
        User::role('section_manager')->cursor()->each(function ($manager) {
            Mail::to($manager->email)->queue(
                new NewBookAddedToAssignMail($this->publisher, $this->book)
            );
        });
    }
}
