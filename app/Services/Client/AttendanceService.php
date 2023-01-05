<?php

namespace App\Services\Client;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $isLate = Carbon::now()->toTimeString() > '08:00:00';
        Attendance::create([
            'user_id' => Auth::id(),
            'check_in' => Carbon::now(),
            'user_code' => Auth::user()->userInformation?->user_code,
            'is_late' => $isLate
        ]);
    }

    /** 
     * store attendance for user
     *
     *
     * @return array
     */
    public function update($request)
    {
        $isLate = Carbon::parse($request->check_in)->toTimeString() > '08:00:00';
        Attendance::whereId($request->id)->update([
            'check_in' => $request->check_in,
            'check_out' => $request->check_out ?? null,
            'time' => $request->check_out ? DB::raw('TIMEDIFF(check_out, check_in)') : null,
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

    /**
     * get list salary
     *
     * @param User $user
     * @param Request $request
     * 
     * @return Collection
     */
    public function getListSalary(Request $request)
    {
        return $this->getDataSalary($request)->get();
    }

    /**
     * get data salary
     *
     * @param Request $request
     * 
     * @return Builder
     */
    public function getDataSalary($request)
    {
        $month = date('m', strtotime($request->month));
        $year = date('Y', strtotime($request->month));
        info($request->toArray());
        return Attendance::query()
            ->select([
                'id',
                'user_id',
                DB::raw(' SUM( TIME_TO_SEC( time) )  as total_time'),
            ])
            ->with([
                'user.userInformation.salary',
                'user.userInformation.position',
                'user.userInformation.department'
            ])
            ->whereMonth('check_in', '=', $month)
            ->whereYear('check_in', '=', $year)
            ->groupBy('user_id');
    }

    /**
     * export CSV salary
     *
     * @param Request $request
     * 
     */
    public function downloadCsvSalary($request)
    {
        $filename = 'salary_' . date('Y-m-d') . '.csv';
        return response()->stream(
            function () use ($request, $filename) {
                $stream = fopen('php://output', 'w+');
                fputcsv($stream, [
                    'ID',
                    'Username',
                    'User code',
                    'Name',
                    'Position',
                    'Department',
                    'Salary',
                ]);
                $this->getDataSalary($request)->chunk(100, function ($attendances) use ($stream) {
                    foreach ($attendances as $attendance) {
                        fputcsv($stream, [
                            $attendance->id,
                            $attendance->user?->username,
                            $attendance->user?->userInformation?->user_code,
                            $attendance->user?->userInformation?->name,
                            $attendance->user?->userInformation?->position?->name,
                            $attendance->user?->userInformation?->department?->name,
                            $attendance->total_time * ($attendance->user?->userInformation?->salary?->salary / 22 / 9 / 60 / 60),
                        ]);
                    }
                });
                fclose($stream);
            },
            \Illuminate\Http\Response::HTTP_OK,
            ['filename' => $filename],
            [
                'Content-Type' => 'Content-Type: text/csv;',
                'Content-Disposition' => 'attachment; filename=' . $filename,
            ]
        );
    }
}
