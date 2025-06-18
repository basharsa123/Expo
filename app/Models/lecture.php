<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lecture extends Model
{
    protected $fillable = [
        "title",
        "description",
        "date",
        "place",
        "location",
        "mentor",
    ];
    protected $casts = [
        "date" => "datetime:Y-m-d H:m:s",
    ];
    /** @use HasFactory<\Database\Factories\LectureFactory> */
    use HasFactory;
}
