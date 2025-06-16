<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
    	'name', 'slug'
    ];

    protected $hidden = [

    ];

    public function post()
    {
        return $this->belongsToMany(Post::class);
    }

    public function video()
    {
        return $this->belongsToMany(Video::class);
    }

    public function photo()
    {
        return $this->belongsToMany(Photo::class);
    }
}
