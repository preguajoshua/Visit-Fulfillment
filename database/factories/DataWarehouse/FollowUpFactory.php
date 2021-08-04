<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\FollowUp;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowUpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FollowUp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ID' => $this->faker->uuid,
            'EntityId' => $this->faker->uuid,
            'UserId' => $this->faker->uuid,
        ];
    }
}
