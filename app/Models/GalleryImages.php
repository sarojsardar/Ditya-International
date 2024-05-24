<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_name',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }
}
