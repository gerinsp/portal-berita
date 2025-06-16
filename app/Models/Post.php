<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
    	'users_id', 
        'categories_id', 
        'sub_categories', 
        'post_title', 
        'post_teaser', 
        'post_content', 
        'slug', 
        'post_status', 
        'post_image',
        'post_image_description',
        'published_at',
    ];

    protected $hidden = [

    ];

    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id','id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id','users_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
