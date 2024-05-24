<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'language_name',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_name');
    }
}
