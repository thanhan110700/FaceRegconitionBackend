<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\CheckOutRequest;
use App\Http\Resources\ListAttendanceForUserResource;
use App\Models\User;
use App\Services\Client\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class AttendanceController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService)
    {
    }

    public function index(Request $request)
    {
        try {
            $data = $this->attendanceService->index($request);
            $totalTime = '00:00:00';

            foreach ($data as $item) {
                $totalTime = addTimeToTime($totalTime, $item->time ?? '00:00:00');
            }
            return $this->responseSuccess([
                'data' => ListAttendanceForUserResource::collection($data),
                'total_time' => $totalTime
            ]);
        } catch (Throwable $th) {
            Log::error("login failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(AttendanceRequest $request)
    {
        try {
            $data = $this->attendanceService->store();

            return $this->responseSuccess(['data' => $data]);
        } catch (Throwable $th) {
            Log::error("login failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function checkOut(CheckOutRequest $request)
    {
        try {
            $data = $this->attendanceService->checkOut();

            return $this->responseSuccess(['data' => $data]);
        } catch (Throwable $th) {
            Log::error("login failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getAttendanceByUser(User $user, Request $request)
    {
        try {
            $data = $this->attendanceService->getAttendancesByUser($user, $request);
            $salaryInHour = $user->userInformation->salary->salary / (22 * 8);
            $totalTime = 0;
            foreach ($data as $item) {
                $time = $item->time ?? '00:00:00';
                $totalTime += convertTimeToHour($time);
            }
            $totalTimeShow = '00:00:00';

            foreach ($data as $item) {
                $totalTimeShow = addTimeToTime($totalTimeShow, $item->time ?? '00:00:00');
            }
            $totalSalary = $totalTime * $salaryInHour;
            return $this->responseSuccess([
                'data' => ListAttendanceForUserResource::collection($data),
                'total_time' => $totalTimeShow,
                'total_salary' => $totalSalary,
            ]);
        } catch (Throwable $th) {
            Log::error("login failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
