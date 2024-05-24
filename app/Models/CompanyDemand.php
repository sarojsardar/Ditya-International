<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyDemand extends Model
{
    use HasFactory;


    protected $fillable = [
        'quota','company_id','demand_code','quota','gender','age_from','age_to','height','weight','experience_year','education','demand_letter','edu_level','status'
    ];

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function candidates(){
        return $this->hasMany(Candidate::class, 'demand_id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function pros(){
    return $this->belongsToMany(User::class, 'quota_allotments', 'demand_id', 'pro_id');
   }
}
