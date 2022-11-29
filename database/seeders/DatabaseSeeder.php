<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartmentTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(SalaryTableSeeder::class);
    }
}
