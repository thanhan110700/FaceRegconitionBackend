<?php

namespace App\Services;

use App\Http\Resources\UserDetailResource;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NotifyService
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
        Message::create([
            'from' => Auth::id(),
            'to' => 1,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * get list message
     *
     * @param Request $request
     *
     * @return Collection
     */
    public function index($request): Collection
    {
        $orderType = $request->orderType ?? 'desc';
        return Message::with('fromUser.userInformation')
            ->orderBy('created_at', $orderType)
            ->when(!empty($request->from), function ($query) use ($request) {
                $query->whereFrom($request->from);
            })
            ->when(isset($request->read) && $request->read != 2, function ($query) use ($request) {
                $query->whereRead($request->read);
            })
            ->when(!empty($request->created_at), function ($query) use ($request) {
                $query->whereDate('created_at', $request->created_at);
            })
            ->when(!empty($request->limit), function ($query) use ($request) {
                $query->limit($request->limit);
            })
            ->get();
    }

    /**
     * update read on Message
     *
     * @param Message $message
     * @param Request $request
     *
     * @return Collection
     */
    public function updateRead($message, $request)
    {
        $message->read = !$message->read;
        $message->save();
        return $this->index($request);
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
