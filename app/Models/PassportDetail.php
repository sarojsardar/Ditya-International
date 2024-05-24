<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassportDetail extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','passport_image', 'passport_number', 'expiry_date','issue_place','passport_issue_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
