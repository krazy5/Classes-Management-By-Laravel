<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $defaultSettings = [
            ['key' => 'institute_name', 'value' => 'ABC Institute'],
            ['key' => 'institute_address', 'value' => '123 Main Street, Mumbai, India'],
            ['key' => 'institute_logo', 'value' => 'uploads/logo.png'],
            ['key' => 'institute_email', 'value' => 'contact@abcinstitute.com'],
            ['key' => 'institute_phone', 'value' => '+91-9876543210'],
        ];

        foreach ($defaultSettings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
