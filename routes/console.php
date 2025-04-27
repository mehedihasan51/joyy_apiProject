<?php

use App\Models\Booking;
use App\Mail\BookingCountMail;
use App\Console\Commands\MakeDto;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Mail;
use App\Console\Commands\MakeService;
use App\Console\Commands\MakeInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\Api\Booking\BookingController;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//# registering make service class command
Artisan::command('make:service {name}', function ($name) {
    $this->call(MakeService::class, ['name' => $name]);
});

//~ registering make interface class command
Artisan::command('make:interface {name}', function ($name) {
    $this->call(MakeInterface::class, ['name' => $name]);
});

//^ registering make dto class command
Artisan::command('make:dto {name}', function ($name) {
    $this->call(MakeDto::class, ['name' => $name]);
});


Schedule::call(function () {
    Mail::to('admin@gmail.com')->send(new BookingCountMail());
})->everyMinute(); // Adjust the frequency as needed