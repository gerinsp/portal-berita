<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
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
        'post_source',
        'post_photographer',
        'post_caption', 
        'post_status'
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

    public function galleries()
    {
    	return $this->hasMany(PhotoGallery::class, 'photos_id','id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
