<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected  $fillable = ['name','desc','phone','email','address'];
    protected $hidden= ["created_at" , "update_at"];
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    public function products() : HasMany
    {
        return $this->hasMany(product::class);
    }


}
