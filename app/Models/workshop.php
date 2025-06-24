<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workshop extends Model
{
    /** @use HasFactory<\Database\Factories\WorkshopFactory> */
    use HasFactory;
    protected $fillable = [
        "title",
        "description",
        "started_date",
        "finished_date",
        "place",
    ];
    protected $casts = [
        "started_date" => "datetime:Y-m-d H:i:s",
        "finished_date" => "datetime:Y-m-d H:i:s",
    ];
}
