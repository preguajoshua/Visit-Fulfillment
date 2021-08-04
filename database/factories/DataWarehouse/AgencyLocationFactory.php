<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\AgencyLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgencyLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Id' => $this->faker->uuid,
            'AgencyId' => $this->faker->uuid,
            'Name' => $this->faker->text,
            'CustomId' => $this->faker->uuid,
            'MedicareProviderNumber' => $this->faker->uuid,
            'AddressLine1' => $this->faker->address,
            'AddressLine2' => $this->faker->secondaryAddress,
            'AddressCity' => $this->faker->city,
            'AddressStateCode' => $this->faker->postcode,
            'AddressZipCode' => $this->faker->postcode,
            'AddressZipCodeFour' => $this->faker->postcode,
            'ZipNineStatus' => $this->faker->postcode,
            'PhoneWork' => $this->faker->phoneNumber,
            'TrackingNumberEffectiveDate' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'IsMainOffice' => $this->faker->numberBetween($min = 0, $max = 1),
            'Created' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'Modified' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'Cost' => $this->faker->numberBetween($min = 0, $max = 100),
            'BillData' => $this->faker->numberBetween($min = 0, $max = 100),
        ];
    }
}