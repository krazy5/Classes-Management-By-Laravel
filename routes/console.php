<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\StudentRecord;
use App\Models\Notification;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $today = now()->format('m-d');

    $students = StudentRecord::whereNotNull('dob')
        ->whereRaw("DATE_FORMAT(dob, '%m-%d') = ?", [$today])
        ->get();

    foreach ($students as $student) {
        Notification::create([
            'title' => '🎂 Birthday Reminder',
            'message' => "Today is {$student->first_name}'s birthday!",
            'audience' => 'admin',
            'is_active' => true,
        ]);
    }
})->daily(); // This will run once every day