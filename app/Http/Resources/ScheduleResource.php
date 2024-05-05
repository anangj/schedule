<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'schedulable_id' => $this->schedulable_id,
            'schedulable_type' => $this->schedulable_type,
            'weekday' => $this->weekday,
            'start_hour' => $this->start_hour,
            'start_minute' => $this->start_minute,
            'end_hour' => $this->end_hour,
            'end_minute' => $this->end_minute,
        ];
    }
}
