<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\Identity;
use Illuminate\Database\Eloquent\Factories\Factory;

class IdentityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Identity::class;

    /**
     * Indicate that the identity is located in a participating state.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function participatingState()
    {
        return $this->state(function (array $attributes) {
            return [
                'StateCode' => 'TX',
            ];
        });
    }

    /**
     * Indicate that the identity is located in a non participating state.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function nonParticipatingState()
    {
        return $this->state(function (array $attributes) {
            return [
                'StateCode' => 'AZ',
            ];
        });
    }

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
            'DisplayName' => $this->faker->name,
            'Type' => $this->faker->numberBetween($min = 1, $max = 3),
            'ZipCode' => $this->faker->postcode,
            'Status' => $this->faker->numberBetween($min = 1, $max = 100),
            'Created' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'IsAxxess' => $this->faker->boolean,
        ];
    }
}
