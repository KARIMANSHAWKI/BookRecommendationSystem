<?php

namespace App\Mails;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUserAfterSubmitIntervalOnBookMail extends Mailable
{
    use Queueable;
    use SerializesModels;

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
    public function build(): static
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
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
