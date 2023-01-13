<?php

namespace App\Http\Resources;

use App\Models\Attendance;
use Illuminate\Http\Resources\Json\JsonResource;

class ListAttendanceForUserResource extends JsonResource
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
            'date' => $this->check_in,
            'image_face' => $this->image_face,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'time' => $this->time,
            'is_late' => $this->is_late,
            'is_late_label' => $this->is_late_label,
        ];
    }
}
