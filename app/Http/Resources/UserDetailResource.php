<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'username' => $this->username,
            'user_code' => $this->userInformation?->user_code,
            'name' => $this->userInformation?->name,
            'birthday' => $this->userInformation?->birthday,
            'department_id' => $this->userInformation?->department_id,
            'position_id' => $this->userInformation?->position_id,
            'salary' => $this->userInformation?->salary?->salary,
            'total_amount' => $this->userInformation?->total_amount,
        ];
    }
}
