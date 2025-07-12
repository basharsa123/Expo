<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class workshop extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\WorkshopFactory> */
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        "title",
        "description",
        "started_date",
        "finished_date",
        "place",
        "mentor"
    ];
    protected $casts = [
        "started_date" => "datetime:Y-m-d H:i:s",
        "finished_date" => "datetime:Y-m-d H:i:s",
    ];
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('workshop_pic')->singleFile();
    }
}
