<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
    * Indicate that the job has a status completed state.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
    public function statusCompleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'Status' => 7,
            ];
        });
    }

    /**
    * Indicate that the job has a status uncompleted state.
    *
    * @return \Illuminate\Database\Eloquent\Factories\Factory
    */
    public function statusUncompleted()
    {
        return $this->state(function (array $attributes) {
            return [
                'Status' => 1,
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
            'FacilityId' => $this->faker->uuid,
            'ClientId' => $this->faker->uuid,
            'ProfessionalId' => $this->faker->uuid,
            'DisciplineId' => $this->faker->uuid,
            'DisciplineTaskId' => $this->faker->numberBetween($min = 1, $max = 305),
            'SpecialityId' => $this->faker->numberBetween($min = 1, $max = 66),
            'VisitRate' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL),
            'MileageRate' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL),
            'Latitude' => $this->faker->latitude($min = -90, $max = 90),
            'Longitude' => $this->faker->longitude($min = -180, $max = 180),
            'Status' => $this->faker->numberBetween($min = 1, $max = 15),
            'VisitDate' => $this->faker->dateTime($max = 'now')->format('Y-m-d H:i:s'),
            'Created' => $this->faker->dateTime($max = 'now')->format('Y-m-d H:i:s'),
            'Modified' => $this->faker->dateTime($max = 'now')->format('Y-m-d H:i:s'),
            'DisciplineTask' => $this->faker->jobTitle,
            'Specialty' => $this->faker->jobTitle,
            'PaidDate' => $this->faker->dateTime($max = 'now')->format('Y-m-d H:i:s'),
            'PaidAmount' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 5, $max = NULL),
            'FacilityReviewStatus' => $this->faker->numberBetween($min = 0, $max = 2),
            'ProfessionalReviewStatus' => $this->faker->numberBetween($min = 0, $max = 2),
            'ProfessionalSignatureAssetId' => $this->faker->uuid,
            'QaExpiration' => $this->faker->dateTime($max = 'now')->format('Y-m-d H:i:s'),
            'EventId' => $this->faker->uuid,
            'EpisodeId' => $this->faker->uuid,
            'VisitChanged' => $this->faker->numberBetween($min = 0, $max = 1),
        ];
    }
}
