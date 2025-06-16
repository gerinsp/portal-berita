<?php

namespace App\Models;

use App\Models\Post;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Headline extends Model
{
    use HasFactory;

    protected $fillable = [
    	'post_id'
    ];

    protected $hidden = [

    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id','id');
    }
}
