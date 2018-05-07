<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Big stage',
            'password' => password_hash('1234', PASSWORD_BCRYPT),
            'phone' => '0968956088'
            ]
        );
    }
}
