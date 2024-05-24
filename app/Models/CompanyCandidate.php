<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCandidate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_id','demand_id','demand_status','interview_status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function interview()
    {
        return $this->hasOne(Interview::class, 'user_id', 'company_id');
    }
}
