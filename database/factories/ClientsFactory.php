<?php

namespace Database\Factories;

use App\Models\Clients;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clients>
 */
class ClientsFactory extends Factory
{
    protected $model = Clients::class;

    public function definition(): array
    {
        return [
            'client_name' => $this->faker->unique()->name(),
            'client_code' => 'CL' . $this->faker->unique()->randomNumber(7),
            'client_document' => $this->faker->unique()->numberBetween(18011955000000, 18012000999999),
            'client_type' => $this->faker->randomElement(['N', 'J']),
            'client_phone1' => $this->faker->unique()->numberBetween(80000000, 99999999),
            'client_phone2' => $this->faker->unique()->numberBetween(80000000, 99999999),
            'client_birthdate' => $this->faker->date(),
            'client_phone_home' => $this->faker->unique()->numberBetween(80000000, 99999999),
            'client_actual_job' => substr($this->faker->jobTitle(), 0, 55),
            'client_job_length' => $this->faker->randomNumber(2),
            'client_phone_work' => $this->faker->unique()->numberBetween(80000000, 99999999),
            'client_last_job' => substr($this->faker->jobTitle(), 0, 55),
            'client_own_business' => $this->faker->boolean(),
            'client_email' => $this->faker->unique()->safeEmail(),
            'client_exonerated' => $this->faker->boolean(),
            'client_status' => $this->faker->boolean(),
            'client_address' => $this->faker->address(),
        ];
    }
}
