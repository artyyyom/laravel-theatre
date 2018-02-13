<?php

use Illuminate\Database\Seeder;

class CategoryPlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_places')->insert([
            'name' => 'Balcony',
            
        ]
        );
        DB::table('category_places')->insert([
            'name' => 'Parterre'   
        ]
        );
    }
}
