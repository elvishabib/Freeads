<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_author' => User::factory(),
            'title' => $this->faker->word,
            'price' => $this->faker->randomNumber(2),
            'description' => $this->faker->word(),
            'category' => $this->faker->word(),
            'location' => $this->faker->word()
            
        ];
    }
}
