<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Job;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckOutAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'checkout user when timed out';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = Attendance::query()
            ->whereNull("check_out")
            ->whereDate("check_in", "<=", Carbon::now()->toDateString())
            ->update([
                "check_out" => Carbon::now()->setHour('17')->setMinute('00')->setSecond('00'),
                "time" => DB::raw('TIMEDIFF(check_out, check_in)')
            ]);

        Log::info("[Attendance] Check out {$result} user by attendance:checkout command");
    }
}
