<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Comment;


class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        $comments = [];
        for ($i = 0; $i < 100; $i++) {
            $comments[] = ['item_id' => $faker->numberBetween(1, 15),
                'description' => $faker->paragraph,
                'userid' => $faker->numberBetween(1, 40),
                'date' => $faker->dateTime()];
        }
        Comment::query()->insert($comments);
    }
}
