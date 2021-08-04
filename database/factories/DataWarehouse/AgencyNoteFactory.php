<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\AgencyNote;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyNoteFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgencyNote::class;

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
