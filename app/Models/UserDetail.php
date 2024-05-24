<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'full_name',
        'permanent_address',
        'temporary_address',
        'father_name',
        'mother_name',
        'marital_status',
        'spouse_name',
        'gender',
        'height',
        'weight',
        'dob',
        'age',
        'has_relatives_in_malaysia',
        'has_been_in_accident'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
