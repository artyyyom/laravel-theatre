<?php

use Illuminate\Database\Seeder;

class PerformancesEmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('performances_employees')->insert([
            'performance_id' => 1,
            'role' => 'Policeman',
            'employee_id' => 1,
        ]
        );
        DB::table('performances_employees')->insert([
            'performance_id' => 2,
            'role' => 'Girls',
            'employee_id' => 2,
        ]
        );
    }
}
