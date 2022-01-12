<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'rating' => $this->faker->numberBetween( 0, 5 ),
            'view' => $this->faker->numberBetween( 0, 1000 ),
            'level' => $this->faker->randomElement( [ 'beginner', 'immediate', 'high' ] ),
            'hours' => $this->faker->numberBetween( 0, 10 ),
        ];
    }

}
