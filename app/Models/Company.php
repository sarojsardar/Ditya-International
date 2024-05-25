<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $table = 'companies';
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function demandDetail(){
        return $this->hasMany(CompanyDemand::class, 'company_id');
    }

    
    public function originCountry(){
        return $this->belongsTo(Country::class, 'country');
    }
}
