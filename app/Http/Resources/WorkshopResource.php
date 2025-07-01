<?php

namespace App\Http\Resources;

use App\Models\registeration;
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
            "started_date" => $this->started_date->format('Y-m-d H:i:s'),
            "finished_date" => $this->finished_date->format('Y-m-d H:i:s'),
            "place" => $this->place,
            "mentor" => $this->mentor,
        "available_slots" => TimeSlotService::generateTimeSlots($this->started_date->format('Y-m-d H:i:s') , $this->finished_date->format('Y-m-d H:i:s')  ,"g:i A" , $this->id),
        ];
    }
}
