<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\ListUserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function login(Request $request)
    {
        try {
            $data = $this->userService->login($request);

            return $this->responseSuccess(['data' => $data]);
        } catch (Throwable $th) {
            Log::error("login failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $this->userService->store($request);

            return $this->responseSuccess(['data' => ''], Response::HTTP_CREATED);
        } catch (Throwable $th) {
            Log::error("Register user failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function index()
    {
        try {
            return $this->responseSuccess(['data' => ListUserResource::collection($this->userService->index())]);
        } catch (Throwable $th) {
            Log::error("Register user failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete(User $user)
    {
        try {
            $this->userService->delete($user);
            return $this->responseSuccess(['data' => []], Response::HTTP_NO_CONTENT);
        } catch (Throwable $th) {
            Log::error("Register user failed " . $th);
            return $this->responseError(
                array($th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
