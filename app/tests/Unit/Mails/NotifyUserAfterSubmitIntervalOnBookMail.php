<?php

use App\Mails\NotifyUserAfterSubmitIntervalOnBookMail;
use App\Models\User;

it('builds the NotifyUserAfterSubmitIntervalOnBookMail correctly', function () {
    // Arrange
    $user = User::factory()->make([
        'email' => 'test@example.com'
    ]);
    $bookName = 'My Book';
    $startPage = 10;
    $endPage = 50;

    // Act
    $mailable = new NotifyUserAfterSubmitIntervalOnBookMail($user, $bookName, $startPage, $endPage);
    $mailable->build();

    // Assert sender
    expect($mailable->from[0]['address'])
        ->toBe(env('MAIL_USERNAME'))
        ->and($mailable->subject)
        ->toBe('Submission Of Reading Interval')
        ->and($mailable->markdown)
        ->toBe('mails.submission-reading-interval')
        ->and($mailable->viewData)->toMatchArray([
            'userData' => $user,
            'bookName' => $bookName,
            'startPage' => $startPage,
            'endPage' => $endPage
        ]);
});
