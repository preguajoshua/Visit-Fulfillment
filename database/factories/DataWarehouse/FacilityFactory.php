<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacilityFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Facility::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Id' => $this->faker->uuid,
            'Name' => $this->faker->name,
            'ContactPersonId' => $this->faker->uuid,
            'TaxId' => $this->faker->uuid,
            'TaxIdType' => $this->faker->numberBetween($min = 0, $max = 1),
            'Status' => $this->faker->numberBetween($min = 0, $max = 1),
            'Created' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'Modified' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'IsDeprecated' => $this->faker->numberBetween($min = 0, $max = 1),
            'Software' => $this->faker->text,
            'ClusterId' => $this->faker->uuid,
            'Identity_Id' => $this->faker->uuid,
            'FacilityPaymentAccountId' => $this->faker->uuid,
            'TransactionFee' => $this->faker->numberBetween($min = 0, $max = 100),
        ];
    }
}