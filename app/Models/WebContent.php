<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'chairman_name',
        'chairman_profile',
        'chairman_message',
        'about_us_banner',
        'about_us_side_banner',
        'about_us_title',
        'about_us_content'
    ];
}
