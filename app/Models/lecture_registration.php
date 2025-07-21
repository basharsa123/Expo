<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class lecture_registration extends Model
{
    /** @use HasFactory<\Database\Factories\LectureRegistrationFactory> */
    use HasFactory;
    protected $fillable = [
        "lecture_id",
        "user_id",
        "notes"
    ];
    public function lecture() :belongsTo
    {
        return $this->belongsTo(lecture::class,'lecture_id');
    }
    public function user() :belongsTo
    {
        return $this->belongsTo(lecture::class,'lecture_id');
    }
}
