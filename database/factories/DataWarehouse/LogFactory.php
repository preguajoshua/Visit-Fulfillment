<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\Log;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Log::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Id' => $this->faker->uuid,
            'EntityId' => $this->faker->uuid,
            'UserId' => $this->faker->uuid,
        ];
    }
}
