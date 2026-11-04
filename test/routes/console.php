<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('app:send0mail {email} {--bcc=}', function($email, $bcc) {
    $this->info('Sending mail to ' . $email . ' with bcc: ' . $bcc ?? '');
});

Schedule::command('app:send-mail four0bulles@gmail.com')->everyMinute();