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
            "id" => $this->id,
                "title" => $this->title,
                "description" => $this->description ?? "no description available",
                "date" => $this->date->format("Y-m-d"),
                "started_at" => $this->started_at->format("g:i A"),
                "finished_at" => $this->finished_at->format("g:i A"),
                "place" => $this->place,
                "speaker" => $this->mentor,
                "speaker_job_title" => $this->mentor_job_title ?? "no description available",
                "speaker_imageUrl" => $this->getFirstMediaUrl()
        ];
    }
}
