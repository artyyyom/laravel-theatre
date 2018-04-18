<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'surname' => 'Gritsay',
            'name' => 'Artyom',
            'middlename' => 'Serg',
            'address' => 'Mariupol',
            'birthday' => '2018-02-06',
            'biography' => 'Cool man full',
            'mobile_number' => '555444',
            'biography_short' => 'Cool man short',
            'photo_main' => '1.png',
            'photos' => '11.png',
            'position_id' => 1         
        ]
        );
        DB::table('employees')->insert([
            'surname' => 'Ivanov',
            'name' => 'Ivan',
            'middlename' => 'Ivanovich',
            'address' => 'Kiev',
            'birthday' => '2017-01-04',
            'biography' => 'Bad man full',
            'mobile_number' => '333222',
            'biography_short' => 'Bad man short',
            'photo_main' => '2.png',
            'photos' => '2.png',
            'position_id' => 2 
        ]
        );
    }
}
