<?php

namespace App\Services\Client;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return $this->getQueryData($request)->get();
    }

    /**
     * get attendance for user
     *
     * @param Request $request
     *
     * @return array
     */
    public function getTotalTime($request)
    {
        return convertSecondToTime($this->getQueryData($request)->sum('time'));
    }

    /**
     * get attendance for user
     *
     * @param Request $request
     *
     * @return Builder
     */
    public function getQueryData($request)
    {
        $month = date('m', strtotime($request->month));
        $year = date('Y', strtotime($request->month));

        return Attendance::whereUserId(Auth::id())
            ->whereMonth('check_in', '=', $month)
            ->whereYear('check_in', '=', $year);
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
            'check_in' => Carbon::now(),
            'is_late' => $isLate
        ]);
    }

    /**
     * store check out for user
     *
     * @return array
     */
    public function checkOut()
    {
        Attendance::query()
            ->whereDate('check_in', '=', date('Y-m-d'))
            ->update([
                "check_out" => Carbon::now(),
                "time" => DB::raw('TIMEDIFF(check_out, check_in)')
            ]);;
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
            ->whereDate('check_in', '=', date('Y-m-d'))
            ->whereNull('check_out')
            ->first('id');
    }

    /**
     * store attendance for user
     *
     * @return array
     */
    public function canCheckOut()
    {
        return !!Attendance::whereUserId(Auth::id())
            ->whereDate('check_in', '=', date('Y-m-d'))
            ->whereNull('check_out')
            ->first('id');
    }

    /**
     * store attendance for user
     *
     * @param User $user
     * @param Request $request
     * 
     * @return array
     */
    public function getAttendancesByUser($user, $request)
    {
        $month = date('m', strtotime($request->month));
        $year = date('Y', strtotime($request->month));
        return Attendance::whereUserId($user->id)
            ->whereMonth('check_in', '=', $month)
            ->whereYear('check_in', '=', $year)
            ->get();
    }
}
