<?php

namespace Database\Factories\DataWarehouse;

use App\Models\DataWarehouse\VisitNote;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VisitNote::class;

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
