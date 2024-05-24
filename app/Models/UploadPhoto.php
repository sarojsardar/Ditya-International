<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'passport_photo', 'full_photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
