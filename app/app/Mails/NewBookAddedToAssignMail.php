<?php

namespace App\Mails;

use App\Models\Book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBookAddedToAssignMail extends Mailable
{
   use Queueable;
   use SerializesModels;
   public function __construct(
        public User $publisher,
        public Book $book
   )
   {
   }

   public function build()
   {
      return $this->from(config('mail.from.address'), config('mail.from.name'))
          ->subject('New book added — assign to a section?')
          ->markdown('mails.new-book-added', [
                'publisher' => $this->publisher,
                'book'      => $this->book,
                // if you have an admin UI route, pass it here:
                'assignUrl' => url("/api/books/{$this->book->id}/section"),
          ]);
   }
}
