<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\Reply;
use App\Models\Like;
use App\Models\Views;
use App\Models\Vote;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create 10 users using the UserFactory
        User::factory(10)->create();
        // create 5 categories using the CategoryFactory
        Category::factory(5)->create();
        // create 20 questions using the QuestionFactory
        Question::factory(20)->create();
        // create 100 replies using the ReplyFactory
        Reply::factory(100)->create()->each(
            function ($reply) {
                // return $reply with 10 likes each
                $reply->likes()->saveMany(Like::factory(10)->make());
            }
        );
        // create 200 votes using the VoteFactory
        Vote::factory(200)->create();
        // create 200 views using the ViewsFactory
        Views::factory(300)->create();

    }
}
