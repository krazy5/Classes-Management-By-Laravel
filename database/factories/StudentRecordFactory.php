<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentRecord>
 */
class StudentRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a fake image
        $imagePath = 'students/' . Str::random(10) . '.jpg';

        // Save fake image
        Storage::disk('public')->put($imagePath, file_get_contents('https://picsum.photos/200'));
        
        return [
        //'photo' => 'students/' . $this->faker->image('public/storage/students', 400, 400, null, false),
        'photo' => $imagePath,
        'student_id' => Str::uuid(),
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'roll_no' => $this->faker->unique()->numerify('R###'),
        'parent_name' => $this->faker->name,
        'dob' => $this->faker->date('Y-m-d', '2010-01-01'),
        'mobile_no' => $this->faker->phoneNumber,
        'gender' => $this->faker->randomElement(['Male', 'Female']),
        'address' => $this->faker->address,
        'batch_name' => $this->faker->word,
        'start_date' => $this->faker->date(),
        'class_subject' => $this->faker->word,
        'school_college' => $this->faker->company,
        'attachment' => null,
        'email' => $this->faker->unique()->safeEmail,
        'std' => $this->faker->randomElement(['8th', '9th', '10th', '11th', '12th']),
        'reciept_no' => $this->faker->unique()->numerify('REC###'),
        'password' => bcrypt('123456'),
    ];  
    }
}
