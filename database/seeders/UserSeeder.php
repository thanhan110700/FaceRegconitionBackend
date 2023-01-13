<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('user_informations')->truncate();

        DB::table('users')->insert([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => Hash::make('123456'),
                'role' => User::ROLE_ADMIN,
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'username' => 'thanhan1107',
                'password' => Hash::make('123456'),
                'role' => User::ROLE_USER,
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'username' => 'vietnam2006',
                'password' => Hash::make('123456'),
                'role' => User::ROLE_USER,
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'username' => 'hovanphi',
                'password' => Hash::make('123456'),
                'role' => User::ROLE_USER,
                'created_at' => Carbon::now(),
            ],
        ]);

        DB::table('user_informations')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'user_code' => 'admin',
                'name' => 'Admin',
                'birthday' => '2000-06-20',
                'department_id' => 2,
                'position_id' => 2,
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'user_code' => 'NV00001',
                'name' => 'Le Vu Thanh An',
                'birthday' => '2000-11-07',
                'department_id' => 1,
                'position_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'user_code' => 'NV00002',
                'name' => 'Nguyen Viet Nam',
                'birthday' => '2000-06-20',
                'department_id' => 2,
                'position_id' => 2,
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'user_id' => 4,
                'user_code' => 'NV00003',
                'name' => 'Ho Van Phi',
                'birthday' => '2000-07-07',
                'department_id' => 1,
                'position_id' => 4,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
