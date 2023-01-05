<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->truncate();
        DB::table('departments')->insert([
            [
                'name' => 'Human Resource',
            ],
            [
                'name' => 'Marketing',
            ],
            [
                'name' => 'Sales',
            ],
            [
                'name' => 'Information Technology',
            ],
        ]);
    }
}
