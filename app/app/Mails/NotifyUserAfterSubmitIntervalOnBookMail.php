<?php

namespace App\Mails;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUserAfterSubmitIntervalOnBookMail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(
        private User   $userData,
        private string $bookName,
        private int    $startPage,
        private int    $endPage,
    )
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'))
            ->subject('Submission Of Reading Interval')
            ->markdown('mails.submission-reading-interval')
            ->with([
                'userData' => $this->userData,
                'bookName' => $this->bookName,
                'startPage' => $this->startPage,
                'endPage' => $this->endPage
            ]);
    }
}
