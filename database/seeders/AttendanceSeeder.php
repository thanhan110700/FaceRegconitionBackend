<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendances')->truncate();
        $data = [];
        User::with('userInformation')->whereRole(User::ROLE_USER)->get()->each(function ($user) use (&$data) {
            for ($i = 0; $i <= 90; $i++) {
                if (Carbon::now()->subDays($i)->dayOfWeek == Carbon::SATURDAY || Carbon::now()->subDays($i)->dayOfWeek == Carbon::SUNDAY) {
                    continue;
                }
                $checkIn = now()->setTimeFromTimeString('08:00:00')->subDays($i)->format('Y-m-d H:i:s');
                $checkOut = now()->setTimeFromTimeString('17:00:00')->subDays($i)->format('Y-m-d H:i:s');
                $time = '09:00:00';
                $data[] = [
                    'user_id' => $user->id,
                    'user_code' => $user->userInformation->user_code,
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'time' => $time,
                    'is_late' => 0,
                ];
            }
        });
        DB::table('attendances')->insert($data);
    }
}
