<?php

use App\Jobs\NotifyUserAfterSubmitIntervalOnBookJob;
use App\Mails\NotifyUserAfterSubmitIntervalOnBookMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('sends a notification email after submitting an interval on a book', function () {
    // Arrange
    Mail::fake();

    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);
    $bookName = 'Sample Book';
    $startPage = 10;
    $endPage = 20;

    $job = new NotifyUserAfterSubmitIntervalOnBookJob(
        $user,
        $bookName,
        $startPage,
        $endPage
    );

    // Act
    $job->handle();

    // Assert
    Mail::assertSent(NotifyUserAfterSubmitIntervalOnBookMail::class, function ($mail) use ($user, $bookName, $startPage, $endPage) {
        return $mail->hasTo($user->email)
            && $mail->userData->is($user)
            && $mail->bookName === $bookName
            && $mail->startPage === $startPage
            && $mail->endPage === $endPage;
    });
});
