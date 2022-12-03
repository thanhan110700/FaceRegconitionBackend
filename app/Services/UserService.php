<?php

namespace App\Services;

use App\Http\Resources\UserDetailResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserService
{
    /**
     * login user
     *
     * @param Request $request
     *
     * @return array
     */
    public function login($request): array
    {
        $credentials = $request->only('username', 'password');
        $token = Auth::attempt($credentials);
        if ($token) {
            $user = User::with('userInformation.department')->whereUsername($request->username)->first();
            $user = UserDetailResource::make($user);
            return [
                'token' => $token,
                'user' => $user
            ];
        }

        throw new Exception('Invalid username or password');
    }

    /**
     * store user
     *
     * @param CreateUserRequest $request
     *
     * @return void
     */
    public function store($request): void
    {
        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role = $request->role ?? 2;
        $user->save();
    }

    /**
     * get list user
     *
     * @param CreateUserRequest $request
     *
     * @return void
     */
    public function index()
    {
        return User::whereRole()->get();
    }
}
