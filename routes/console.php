<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('login', function () {
    fwrite(STDERR, "Email \n");
    $email = trim(fgets(STDIN));
    fwrite(STDERR, "Password \n");
    $password = trim(fgets(STDIN));

    $auth = new \App\Http\Controllers\AuthController();
    $auth->login([
        'email' => $email,
        'password' => $password
    ]);
});
