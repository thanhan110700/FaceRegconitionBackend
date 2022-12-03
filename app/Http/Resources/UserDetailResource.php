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
            'name' => $this->userInformation?->name,
            'birthday' => $this->userInformation?->birthday,
            'department' => $this->userInformation?->department?->name,
            'position' => $this->userInformation?->position?->name,
            'salary' => $this->userInformation?->salary?->salary,
            'total_amount' => $this->userInformation?->total_amount,
        ];
    }
}
