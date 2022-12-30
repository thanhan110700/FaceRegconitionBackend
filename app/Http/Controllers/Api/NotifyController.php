<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotifyResource;
use App\Models\Message;
use App\Services\NotifyService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class NotifyController extends Controller
{
    public function __construct(protected NotifyService $notifyService)
    {
    }

    public function index(Request $request)
    {
        try {
            $data = $this->notifyService->index($request);

            return $this->responseSuccess(['data' => NotifyResource::collection($data)]);
        } catch (Throwable $th) {
            Log::error("send message failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $this->notifyService->store($request);

            return $this->responseSuccess(['data' => []]);
        } catch (Throwable $th) {
            Log::error("send message failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updateRead(Message $message, Request $request)
    {
        try {
            $data = $this->notifyService->updateRead($message, $request);

            return $this->responseSuccess(['data' => NotifyResource::collection($data)]);
        } catch (Throwable $th) {
            Log::error("send message failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
