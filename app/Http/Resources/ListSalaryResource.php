<?php

namespace App\Http\Resources;

use App\Models\Attendance;
use Illuminate\Http\Resources\Json\JsonResource;

class ListSalaryResource extends JsonResource
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
            'username' => $this->user?->username,
            'name' => $this->user?->userInformation?->name,
            'position' => $this->user?->userInformation?->position?->name,
            'department' => $this->user?->userInformation?->department?->name,
            'salary' => $this->total_time * ($this->user?->userInformation?->salary?->salary / 22 / 9 / 60 / 60),
        ];
    }
}
