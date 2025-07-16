<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enquiry>
 */
class EnquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     protected $model = \App\Models\Enquiry::class;
    public function definition(): array
    {
        return [
            //
             'full_name' => $this->faker->name,
            'contact_number' => $this->faker->numerify('9#########'),
            'email' => $this->faker->unique()->safeEmail,
            'location' => $this->faker->city,
            'course_interested' => $this->faker->randomElement(['Web Development', 'Data Science', 'Commerce', 'BSC IT', 'NEET Coaching']),
            'fees_offered' => $this->faker->randomFloat(2, 3000, 15000),
            'enquiry_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Pending', 'Contacted', 'Joined', 'Not Interested']),
            'remark' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
