<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService)
    {
    }

    public function msData()
    {
        try {
            $data = $this->dashboardService->msData();

            return $this->responseSuccess(['data' => $data]);
        } catch (Throwable $th) {
            Log::error("get ms data failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
