<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\Professional;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfessionalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Professional::class;

    /**
     * Indicate that the professional has an approved status.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function approvedStatus()
    {
        return $this->state(function (array $attributes) {
            return [
                'Status' => 6,
            ];
        });
    }

    /**
     * Indicate that the professional has an undefined status.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function undefinedStatus()
    {
        return $this->state(function (array $attributes) {
            return [
                'Status' => 9,
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
            'ProfilePictureId' => $this->faker->uuid,
            'Status' => ($this->faker->boolean($chanceOfGettingTrue = 90)) ? $this->faker->NumberBetween($min = 1, $max = 6) : $this->faker->NumberBetween($min = 7, $max = 100),
            'IsDeprecated' => $this->faker->NumberBetween($min = 0, $max = 1),
            'Created' => $this->faker->dateTime($max = 'now')->format('Y-m-d H:i:s'),
            'Modified' => $this->faker->dateTime($max = 'now')->format('Y-m-d H:i:s'),
            'DOB' => $this->faker->dateTimeThisCentury($max = 'now')->format('Y-m-d H:i:s'),
            'DriversLicenseExpiration' => $this->faker->dateTimeThisCentury($max = 'now')->format('Y-m-d H:i:s'),
            'FirstName' => $this->faker->firstName(),
            'LastName' => $this->faker->lastName(),
            'FinishedSignup' => $this->faker->NumberBetween($min = 0, $max = 1),
            'MinimumPayRate' => $this->faker->randomFloat(2, 10, 100),
            'MaximumPayRate' => $this->faker->randomFloat(2, 10, 500),
            'MaxDistancePreference' => $this->faker->NumberBetween($min = 0, $max = 100),
            'IsProfilePhotoVerified' => $this->faker->NumberBetween($min = 0, $max = 1),
            'IsPhoneNumberVerified' => $this->faker->NumberBetween($min = 0, $max = 1),
            'RecieveTextMessages' => $this->faker->NumberBetween($min = 0, $max = 1),
            'Rating' => $this->faker->NumberBetween($min = 1, $max = 5),
            'NumberOfReviewers' => $this->faker->NumberBetween($min = 1, $max = 10),
            'PaymentAccountStatus' => $this->faker->NumberBetween($min = 1, $max = 10),
            'MinnesotaOklahomaRecieveCopy' => $this->faker->NumberBetween($min = 0, $max = 1),
            'CaliforniaRecieveCopy' => $this->faker->NumberBetween($min = 0, $max = 1),
            'BackgroundComplete' => $this->faker->dateTime($max = 'now')->format('Y-m-d H:i:s'),
            'OigPassDate' => $this->faker->dateTime($max = 'now')->format('Y-m-d H:i:s'),
            'Latitude' => $this->faker->latitude($min = -90, $max = 90),
            'Longitude' => $this->faker->longitude($min = -180, $max = 180),
        ];
    }
}
