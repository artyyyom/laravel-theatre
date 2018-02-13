<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            'name' => 'Актеры',
            'order' => '1'
        ]);
        DB::table('positions')->insert([
            'name' => 'Режиссеры',
            'order' => '2'
        ]);
    }
}
