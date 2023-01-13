<?php

namespace App\Services\Admin;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function msData()
    {
        $totalUser = User::whereRole(User::ROLE_USER)->count();
        $attendanceOfMonth = Attendance::select(DB::raw('count(*) as total, DATE_FORMAT(check_in, "%Y-%m") as date'))
            ->groupBy('date')
            ->get();
        return [
            'totalUser' => $totalUser,
            'attendanceOfMonth' => $attendanceOfMonth
        ];
    }
}
