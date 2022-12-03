<?php

namespace App\Services;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceService
{
    /**
     * get attendance for user
     *
     * @param Request $request
     *
     * @return array
     */
    public function index($request)
    {
        $month = date('m', strtotime($request->month));
        $year = date('Y', strtotime($request->month));

        return Attendance::whereUserId(Auth::id())
            ->whereMonth('datetime', '=', $month)
            ->whereYear('datetime', '=', $year)
            ->get();
    }

    /**
     * store attendance for user
     *
     *
     * @return array
     */
    public function store()
    {
        $isLate = Carbon::now()->toTimeString() > '09:00:00';
        Attendance::create([
            'user_id' => Auth::id(),
            'datetime' => now(),
            'is_late' => $isLate
        ]);
    }

    /**
     * store attendance for user
     *
     *
     * @return array
     */
    public function checkExistAttendance()
    {
        return !Attendance::whereUserId(Auth::id())
            ->whereDate('datetime', '=', date('Y-m-d'))
            ->first();
    }
}
