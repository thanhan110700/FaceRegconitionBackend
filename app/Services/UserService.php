<?php

namespace App\Services;

use App\Http\Resources\UserDetailResource;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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
        $userInformation = $user->userInformation()->create([
            'name' => $request->name,
            'birthday' => $request->birthday,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
        ]);
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
     * @return Collection
     */
    public function index(): Collection
    {
        return User::with([
            'userInformation.position',
            'userInformation.department',
            'userInformation.salary'
        ])
            ->whereRole(User::ROLE_USER)
            ->get();
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
