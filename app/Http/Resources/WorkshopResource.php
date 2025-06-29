<?php

namespace App\Http\Resources;

use App\Services\TimeSlotService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkshopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "started_date" => $this->started_date->format('Y-m-d'),
            "finished_date" => $this->finished_date->format('Y-m-d'),
            "place" => $this->place,
            "mentor" => $this->mentor,
            "available_slots" => TimeSlotService::generateTimeSlots($this->started_date->format('Y-m-d H:i:s') , $this->finished_date->format('Y-m-d H:i:s')  ,"H:i"),
        ];
    }
}
