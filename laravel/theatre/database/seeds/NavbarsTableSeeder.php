<?php

use Illuminate\Database\Seeder;

class NavbarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('navbars')->insert([
            'name' => 'News',
            'order' => 1
        ]
        );
        DB::table('navbars')->insert([
            'name' => 'Performances',
            'order' => 2
        ]
        );
    }
}
