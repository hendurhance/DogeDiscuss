<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\View;
use App\Models\Question;


class ViewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'question_id' => function () {
                return Question::all()->random()->id;
            },
            'traffic_source' => $this->faker->randomElement(['web', 'email', 'social', 'api']),
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
        ];
    }
}
