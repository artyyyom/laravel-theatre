<?php

use Illuminate\Database\Seeder;

class SeancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seances')->insert([
            'date' => '2018-02-20',
            'time' => '03:14:00',
            'performance_id' => 1,
            'stage_id' => 1
        ]
        );
        DB::table('seances')->insert([
            'date' => '2018-02-20',
            'time' => '03:14:00',
            'performance_id' => 2,
            'stage_id' => 1
        ]
        );
    }
}
