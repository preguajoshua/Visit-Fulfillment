<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\CustomJobRate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomJobRateFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomJobRate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'JobId' => $this->faker->uuid,
            'Role' => $this->faker->numberBetween($min = 0, $max = 11),
            'Rate' => $this->faker->numberBetween($min = 0, $max = 100),
        ];
    }
}