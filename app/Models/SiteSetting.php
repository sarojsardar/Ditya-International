<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_logo',
        'site_log_sm',
        'location',
        'map',
        'contact',
        'description',
        'terms_and_condition',
        'fb_link',
        'insta_link',
        'official_email',
        'tiktok_link',
        'whatsapp',
        'privacy_and_policy'
    ];
}
