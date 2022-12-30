<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotifyResource extends JsonResource
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
            'from' => $this->fromUser?->userInformation?->name,
            'username' => $this->fromUser?->name,
            'message' => $this->message,
            'read' => $this->read,
            'created_at' => $this->created_at,
        ];
    }
}
