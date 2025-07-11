<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class lecture extends Model implements HasMedia
{
     use InteractsWithMedia;
    protected $fillable = [
        "title",
        "description",
        "date",
        "started_at",
        "finished_at",
        "place",
        "mentor",
        "mentor_job_title"
    ];
    protected $casts = [
        "date" => "datetime:Y-m-d",
        "started_at" => "datetime:H:i",
        "finished_at" => "datetime:H:i",
    ];
    /** @use HasFactory<\Database\Factories\LectureFactory> */
    use HasFactory;
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('mentor_pic')->singleFile();
        $this->addMediaCollection('lecture_pic')->singleFile();
    }
}
