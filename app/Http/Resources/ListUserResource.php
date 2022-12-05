<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListUserResource extends JsonResource
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
            'id' => $this->id,
            'user_code' => $this->userInformation?->user_code,
            'username' => $this->username,
            'name' => $this->userInformation?->name,
            'birthday' => $this->userInformation?->birthday,
            'department' => $this->userInformation?->department?->name,
            'position' => $this->userInformation?->position?->name,
            'total_amount' => $this->userInformation?->total_amount,
        ];
    }
}
