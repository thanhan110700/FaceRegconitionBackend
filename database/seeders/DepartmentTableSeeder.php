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
                'name' => 'Quản lý nhân sự',
            ],
            [
                'name' => 'Chuyên viên tư vấn',
            ],
            [
                'name' => 'Chuyên viên kinh doanh',
            ],
            [
                'name' => 'Kỹ sư Công nghệ thông tin',
            ],
        ]);
    }
}
