<?php

namespace App\Services;

use App\Http\Resources\UserDetailResource;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $user = User::with(['userInformation.department', 'userInformation.position'])->whereUsername($request->username)->first();
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
        DB::transaction(function () use ($request) {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => User::ROLE_USER
            ]);

            $user->userInformation()->create([
                'name' => $request->name,
                'birthday' => $request->birthday,
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'user_code' => 'NV' . rand(10000, 99999)
            ]);
        });
    }

    /**
     * get list user
     *
     * @param CreateUserRequest $request
     *
     * @return Paginator
     */
    public function index($request)
    {
        $a = User::with([
            'userInformation.position',
            'userInformation.department',
            'userInformation.salary'
        ])
            ->when(isset($request->id), function ($query) use ($request) {
                $query->whereId($request->id);
            })
            ->when(isset($request->name), function ($query) use ($request) {
                $query->whereHas('userInformation', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                });
            })
            ->when(isset($request->department_id) && $request->department_id != 0, function ($query) use ($request) {
                $query->whereHas('userInformation', function ($query) use ($request) {
                    $query->where('department_id', $request->department_id);
                });
            })
            ->when(isset($request->position_id) && $request->position_id != 0, function ($query) use ($request) {
                $query->whereHas('userInformation', function ($query) use ($request) {
                    $query->where('position_id', $request->position_id);
                });
            })
            ->when(isset($request->user_code), function ($query) use ($request) {
                $query->whereHas('userInformation', function ($query) use ($request) {
                    $query->where('user_code', $request->user_code);
                });
            })
            ->when(isset($request->is_training) && $request->is_training != 2, function ($query) use ($request) {
                $query->whereHas('userInformation', function ($query) use ($request) {
                    $query->where('is_training', $request->is_training);
                });
            })
            ->whereRole(User::ROLE_USER)
            ->paginate(10);
        return $a;
    }

    /**
     * get detail user
     *
     * @param User $user
     *
     * @return Collection
     */
    public function show($user)
    {
        return $user->load([
            'userInformation.position',
            'userInformation.department'
        ]);
    }

    /**
     * delete user
     *
     * @param User $request
     *
     * @return void
     */
    public function delete($user): void
    {
        $user->delete();
    }

    /**
     * update user
     *
     * @param UpdateUserRequest $request
     * @param User $user
     *
     * @return void
     */
    public function update($request, $user): void
    {
        DB::transaction(function () use ($request, $user) {
            $user->username = $request->username;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $userInformation = $user->userInformation;
            $userInformation->name = $request->name;
            $userInformation->position_id = $request->position_id;
            $userInformation->department_id = $request->department_id;
            $userInformation->birthday = $request->birthday;
            $user->save();
            $userInformation->save();
        });
    }
}
