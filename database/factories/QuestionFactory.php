<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(5, 10));
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->paragraphs(rand(3, 5), true),
            'category_id' => function () {
                return Category::all()->random();
            },
            'user_id' => function () {
                return User::all()->random();
            },
            
        ];
    }
}
