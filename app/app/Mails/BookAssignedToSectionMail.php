<?php
namespace App\Mails;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookAssignedToSectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Book $book) {}

    public function build()
    {
            return $this->from(config('mail.from.address'), config('mail.from.name'))
                ->subject('Congratulations — your book has been added to a section')
                ->markdown('mails.book-assigned', [
                    'book'      => $this->book,
                    'publisher' => $this->book->publisher,
                    'section'   => $this->book->section,
                    'viewUrl'   => url("/api/books/{$this->book->id}"), // adjust if you have an admin UI
                ]);
    }
}
