<?php

namespace Database\Factories;

use App\Models\SeniorCitizen;
use App\Models\City;
use App\Models\Barangay;
use App\Models\Purok;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeniorCitizenFactory extends Factory
{
    protected $model = SeniorCitizen::class;

    public function definition()
    {
        return [
            'osca_id' => $this->faker->unique()->numerify('OSCA-######'),
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->lastName,
            'extension' => $this->faker->optional()->randomElement(['Jr.', 'Sr.', 'III', 'IV']),
            'birthday' => $this->faker->date('Y-m-d'),
            'age' => $this->faker->numberBetween(60, 100),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Widowed', 'Divorced']),
            'religion' => $this->faker->randomElement(['Catholic', 'Protestant', 'Islam', 'Buddhism', 'Others']),
            'birth_place' => $this->faker->city,
            'city_id' => City::factory(),
            'barangay_id' => Barangay::factory(),
            'purok_id' => Purok::factory(),
            'gsis_id' => $this->faker->optional()->numerify('GSIS-########'),
            'philhealth_id' => $this->faker->optional()->numerify('PH-############'),
            'illness' => $this->faker->optional()->sentence,
            'disability' => $this->faker->optional()->word,
            'educational_attainment' => $this->faker->randomElement(['Elementary', 'High School', 'College', 'Vocational', 'Post Graduate']),
            'is_active' => $this->faker->boolean(80),
            'registry_number' => $this->faker->unique()->numerify('REG-######'),
        ];
    }
}
