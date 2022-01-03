<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vote;
use App\Models\Question;
use App\Models\User;

class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_count = User::all()->count();
        $question_count = Question::all()->count();
        $votes_array = [];

        for($i = 1; $i <= $user_count; $i++) {
            for($j = 1; $j <= $question_count; $j++) {
                array_push($votes_array, [
                    'user_id' => $i,
                    'question_id' => $j,
                    'vote' => $this->faker->randomElement(['up', 'down']),
                ]);
            }
        }

        $user_and_question = $this->faker->unique()->randomElement($votes_array);

        // check if vote already exists for this user and question
        $vote = Vote::where('user_id', $user_and_question['user_id'])
            ->where('question_id', $user_and_question['question_id'])
            ->first();


        // if vote exits, move to next vote
        if($vote) {
            $user_and_question = $this->faker->unique()->randomElement($votes_array);
        }

        return [
            'user_id' => $user_and_question['user_id'],
            'question_id' => $user_and_question['question_id'],
            'vote' => $user_and_question['vote'],
        ];
    }
}
