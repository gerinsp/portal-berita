<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    use HasFactory;

    protected $table = 'post_tag';

    protected $fillable = [
    	'post_id', 'tag_id'
    ];

    protected $hidden = [

    ];

    public function post()
    {
        return $this->hasMany(Post::class, 'id','post_id');
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
