<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model
{
    use HasFactory;

    protected $fillable = [
    	'photos',
    	'photos_id'
    ];

    protected $hidden = [

    ];

    public function product()
    {
    	return $this->belongsTo(Photo::class, 'photos_id','id');
    }
}
