<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>$this->id,
            "user" => new UserResource($this->user),
            "workshop" => new WorkshopResource($this->workshop),
            "user_date" => $this->user_date->format("g:i A"),
            "notes" => $this->notes
        ];
    }
}
