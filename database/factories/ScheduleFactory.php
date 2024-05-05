<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Schedule;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'schedulable_id' => $this->faker->word,
            'schedulable_type' => $this->faker->word,
            'weekday' => $this->faker->word,
            'start_hour' => $this->faker->numberBetween(-10000, 10000),
            'start_minute' => $this->faker->numberBetween(-10000, 10000),
            'end_hour' => $this->faker->numberBetween(-10000, 10000),
            'end_minute' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
