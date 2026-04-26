<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment('Stay focused and keep building.');
})->purpose('Display an inspiring message');

Schedule::command('posts:archive')->daily();