<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ForgetAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:forget';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'forget user when timed out';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $listId = User::get('id')->pluck('id')->toArray();
        $listAttendance = Attendance::query()
            ->whereDate("check_in", "=", Carbon::now()->toDateString())
            ->get();
        $listId = $listAttendance->pluck('user_id')
            ->toArray();
        $listIdDiff = array_diff($listId, $listId);
        Attendance::insert(
            array_map(function ($id) {
                return [
                    'user_id' => $id,
                    'user_code' => $id,
                    'check_in' => Carbon::now(),
                    'check_out' => Carbon::now(),
                    'time' => 0,
                    'is_late' => Attendance::FORGET,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }, $listIdDiff)
        );
        Log::info("[Attendance] get Forget user by attendance:forget command");
    }
}
