<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class BreakingNewsCategory extends Model
{
    use HasFactory;
    
    protected $table = 'breaking_news_categories';

    protected $fillable = [
    	'post_id',
    	'category_id',
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
