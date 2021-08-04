<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\JobApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Id' => $this->faker->uuid,
            'JobId' => $this->faker->uuid,
            'ProfessionalId' => $this->faker->uuid,
            'Status' => $this->faker->numberBetween($min = 0, $max = 9),
            'HasWorkedWithPatient' => $this->faker->numberBetween($min = 0, $max = 1),
            'HasWorkedWithFacility' => $this->faker->numberBetween($min = 0, $max = 1),
            'Created' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        ];
    }
}
