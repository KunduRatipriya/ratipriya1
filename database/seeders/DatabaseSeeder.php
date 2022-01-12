<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker=Faker::create();
        foreach(range(1,30) as $list) {
            DB::table('users')->insert(
                [
                    'fullname'=>$faker->name,
                    'username'=>$faker->username,
                    'email'=>$faker->email,
                    'password'=>$faker->password
                ]
            );
        }
    }
}
