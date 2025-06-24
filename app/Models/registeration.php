<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registeration extends Model
{
    /** @use HasFactory<\Database\Factories\RegisterationFactory> */
    use HasFactory;
    protected $fillable = [
        "user_id", //belongs to one
        "workshop_id", //belongs to one
        "mentor_id", //belongs to one
        "user_date",
        "notes"
    ];
    protected $casts = [
        "user_date" => "datetime:Y-m-d H:i:s",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function workshop()
    {
        return $this->belongsTo(workshop::class);
    }
}
