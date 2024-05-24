<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'edu_doc',
        'level',
        'edu_level',
        'school_college_name',
        'pass_year',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


}
