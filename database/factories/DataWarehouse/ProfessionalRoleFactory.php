<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\ProfessionalRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfessionalRoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProfessionalRole::class;

    /**
     * Indicate that the professional is a registered nurse.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function rn()
    {
        return $this->state(function (array $attributes) {
            return [
                'Role' => 5,
            ];
        });
    }

    /**
     * Indicate that the professional is a physical theropist.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pt()
    {
        return $this->state(function (array $attributes) {
            return [
                'Role' => 7,
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
            'ProfessionalId' => $this->faker->uuid,
            'Years' => $this->faker->numberBetween($min = 0, $max = 100),
            'Months' => $this->faker->numberBetween($min = 0, $max = 11),
            'Role' => $this->faker->numberBetween($min = 1, $max = 8),
        ];
    }
}
