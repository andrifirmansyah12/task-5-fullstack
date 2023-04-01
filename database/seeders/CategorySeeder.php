<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

    	for($i = 1; $i <= 10; $i++){

    	      // insert data ke table users menggunakan Faker
    		DB::table('categories')->insert([
                'name_category' => $faker->title(),
                'user_id' => $faker->numberBetween(1, User::count())
    		]);
    	}
    }
}
