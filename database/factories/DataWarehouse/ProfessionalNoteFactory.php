<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\ProfessionalNote;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfessionalNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProfessionalNote::class;

    /**
     * Indicate that the professional has the given rating.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function rating($ratingDescription)
    {
        $ratingRange = ProfessionalNote::ratingRangeFromDescription($ratingDescription);

        return $this->state(function (array $attributes) use ($ratingRange) {
            return [
                'Rating' => $ratingRange[0],
            ];
        });
    }

    /**
     * Indicate that the professional is not an axxessian.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function nonAxxessian()
    {
        return $this->state(function (array $attributes) {
            return [
                'isAxxessian' => 0,
            ];
        });
    }

    /**
     * Indicate that the professional is an axxessian.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function axxessian()
    {
        return $this->state(function (array $attributes) {
            return [
                'isAxxessian' => 1,
            ];
        });
    }

    /**
     * Indicate that the professional is 'Paused'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function paused()
    {
        return $this->state(function (array $attributes) {
            return [
                'isPaused' => 1,
            ];
        });
    }

    /**
     * Indicate to 'Do Not Contact' the professional.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function doNotContact()
    {
        return $this->state(function (array $attributes) {
            return [
                'isDnc' => 1,
            ];
        });
    }

    /**
     * Indicate to that the professional is a 'Star Responder'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function starResponder()
    {
        return $this->state(function (array $attributes) {
            return [
                'isStarResponder' => 1,
            ];
        });
    }

    /**
     * Indicate to that the professional has a 'Technical Issue'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function techIssue()
    {
        return $this->state(function (array $attributes) {
            return [
                'isTechIssue' => 1,
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
            'id' => $this->faker->uuid,
        ];
    }
}
