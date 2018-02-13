<?php

use Illuminate\Database\Seeder;

class StagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stages')->insert([
            'name' => 'Big stage',
        ]
        );
        DB::table('stages')->insert([
            'name' => 'Small stage',
        ]
        );
    }
}
