<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->truncate();
        DB::table('positions')->insert([
            [
                'name' => 'Giám đốc',
            ],
            [
                'name' => 'Trưởng phòng',
            ],
            [
                'name' => 'Phó phòng',
            ],
            [
                'name' => 'Nhân viên',
            ],
        ]);
    }
}
