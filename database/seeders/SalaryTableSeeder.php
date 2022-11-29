<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salaries')->truncate();
        DB::table('salaries')->insert([
            [
                'department_id' => 1,
                'position_id' => 1,
                'salary' => 10000000,
            ],
            [
                'department_id' => 2,
                'position_id' => 1,
                'salary' => 15000000,
            ],
            [
                'department_id' => 3,
                'position_id' => 1,
                'salary' => 12000000,
            ],
            [
                'department_id' => 4,
                'position_id' => 1,
                'salary' => 11000000,
            ],
            [
                'department_id' => 1,
                'position_id' => 2,
                'salary' => 9000000,
            ],
            [
                'department_id' => 2,
                'position_id' => 2,
                'salary' => 9900000,
            ],
            [
                'department_id' => 3,
                'position_id' => 2,
                'salary' => 98000000,
            ],
            [
                'department_id' => 4,
                'position_id' => 2,
                'salary' => 95000000,
            ],
            [
                'department_id' => 1,
                'position_id' => 3,
                'salary' => 12000000,
            ],
            [
                'department_id' => 2,
                'position_id' => 3,
                'salary' => 11000000,
            ],
            [
                'department_id' => 3,
                'position_id' => 3,
                'salary' => 1000000,
            ],
            [
                'department_id' => 4,
                'position_id' => 3,
                'salary' => 7000000,
            ],
            [
                'department_id' => 1,
                'position_id' => 4,
                'salary' => 6000000,
            ],
            [
                'department_id' => 2,
                'position_id' => 4,
                'salary' => 15000000,
            ],
            [
                'department_id' => 3,
                'position_id' => 4,
                'salary' => 12000000,
            ],
            [
                'department_id' => 4,
                'position_id' => 4,
                'salary' => 11000000,
            ],
        ]);
    }
}
