<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['name','desc' , "company_id"];
    protected $hidden= ["created_at" , "update_at"];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
