<?php

namespace App\Jobs;

use App\Mails\NotifyUserAfterSubmitIntervalOnBookMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUserAfterSubmitIntervalOnBookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(
        private User   $userData,
        private string $bookName,
        private int    $startPage,
        private int    $endPage,
    )
    {
    }


    public function handle()
    {
        Mail::to($this->userData['email'])->send(new NotifyUserAfterSubmitIntervalOnBookMail($this->userData, $this->bookName, $this->startPage, $this->endPage));
    }
}
