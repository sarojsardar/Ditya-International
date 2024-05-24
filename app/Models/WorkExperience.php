<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'company_name',
        'position',
        'description',
        'country',
        'no_of_years',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
