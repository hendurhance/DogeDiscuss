<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $word = $this->faker->word;
        return [
            'name' => $word,
            'slug' => Str::slug($word),
        ];
    }
}
