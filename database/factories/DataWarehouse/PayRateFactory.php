<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\PayRate;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayRateFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PayRate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Id' => $this->faker->uuid,
            'FacilityId' => $this->faker->uuid,
            'RnCost' => $this->faker->numberBetween($min = 0, $max = 100),
            'LvnLpnCost' => $this->faker->numberBetween($min = 0, $max = 100),
            'HhaCost' => $this->faker->numberBetween($min = 0, $max = 100),
            'MswCost' => $this->faker->numberBetween($min = 0, $max = 100),
            'PtCost' => $this->faker->numberBetween($min = 0, $max = 100),
            'PtaCost' => $this->faker->numberBetween($min = 0, $max = 100),
            'OtCost' => $this->faker->numberBetween($min = 0, $max = 100),
            'PerMileReimbursement' => $this->faker->numberBetween($min = 0, $max = 100),
            'SupppliesAllowance' => $this->faker->numberBetween($min = 0, $max = 100),
            'RuralJobAllowance' => $this->faker->numberBetween($min = 0, $max = 100),
            'Created' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'Modified' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        ];
    }
}