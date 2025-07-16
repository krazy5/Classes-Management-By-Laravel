<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
    
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('admin')->insert([
            [
                'admin_id' => 1,
                'full_name' => 'Mohsin khan',
                'contact' => '9930076555',
                'email' => 'mohsin.mohsin6@gmail.com',
                'password' => Hash::make('mmkmnkak'),
                'user_name' => 'mohsin',
                'created_at' => Carbon::parse('2024-08-16 15:48:06'),
                'updated_at' => Carbon::parse('2024-08-16 15:48:06'),
            ],
            [
                'admin_id' => 2,
                'full_name' => 'mohsin mohammad shamim khan',
                'contact' => '8369286385',
                'email' => 'santrapvtltd@gmaill.com',
                'password' => Hash::make('1234'),
                'user_name' => 'admin',
                'created_at' => Carbon::parse('2024-08-16 15:49:27'),
                'updated_at' => Carbon::parse('2024-08-16 15:49:27'),
            ],
            [
                'admin_id' => 3,
                'full_name' => 'Hamza Shaikh',
                'contact' => '7045006672',
                'email' => 'hmsk.tech@gmail.com',
                'password' => Hash::make('abcd'),
                'user_name' => 'hamza',
                'created_at' => Carbon::parse('2025-01-27 15:07:46'),
                'updated_at' => Carbon::parse('2025-01-27 15:07:46'),
            ],
        ]);
    }
}
