<?php

use Illuminate\Database\Seeder;

class PerformancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('performances')->insert([
            'name' => 'Hello, Kitty',
            'genre' => 'Drama',
            'duration' => '1h 20min',
            'description' => 'Cool girls',
            'photo_main' => '1.png',
            'photos' => '11.png'
        ]);
        DB::table('performances')->insert([
            'name' => 'Goodbye, Sara',
            'genre' => 'Comedy',
            'duration' => '2h 40min',
            'description' => 'Bad girls',
            'photo_main' => '2.png',
            'photos' => '22.png'
        ]);
    }
}
