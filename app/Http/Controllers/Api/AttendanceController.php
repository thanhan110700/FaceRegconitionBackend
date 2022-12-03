<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Services\AttendanceService;
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

            return $this->responseSuccess(['data' => $data]);
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
}
