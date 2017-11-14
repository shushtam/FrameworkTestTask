<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;

class UsersTableSeeder extends Seeder
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
        $users = [];
        for ($i = 0; $i < 40; $i++) {
            $users[] = ['name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('123456') //putting for all same password for easy access, login as it is encrypted in db
            ];
        }
        User::query()->insert($users);
    }
}
