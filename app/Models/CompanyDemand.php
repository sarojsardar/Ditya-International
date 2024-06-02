<?php

namespace App\Models;

use App\Models\Candidat\MedicalCheckup;
use App\Models\Candidate\VisaProcess;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyDemand extends Model
{
    use HasFactory;

    protected $appends=['new_company'];
    protected $guarded=[];


    // this is wrong relationship, i mean i have not idea where it is used, if i override then the issue may be occurd
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getNewCompanyAttribute()
    {
        $company = null;
        $companyUser = User::where('id', $this->company_id)->first();
        if($companyUser){
            $company = Company::where('user_id', $companyUser->id)->first();
        }
        return $company;
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


    public function pros()
    {
        return $this->belongsToMany(User::class, 'quota_allotments', 'demand_id', 'pro_id');
    }

    public function medicalCheckup():HasMany
    {
        return $this->hasMany(MedicalCheckup::class, 'demad_id');
    }

    public function visaProcesses():HasMany
    {
        return $this->hasMany(VisaProcess::class, 'demad_id');
    }
}
