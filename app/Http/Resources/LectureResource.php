<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title" => $this->title,
            "description" => $this->description ?? "no description available",
            "date" => $this->date->format("Y-m-d H:i:s"),
            "place" => $this->place,
            "location" => $this->location,
            "mentor" => $this->mentor
        ];
    }
}
