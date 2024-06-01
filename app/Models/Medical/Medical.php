<?php

namespace App\Models\Medical;

use App\Models\Candidat\MedicalCheckup;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medical extends Model
{
    use HasFactory;
    protected $guarded=[];

   //  user type MEDICAL_OFFICER and the user role is Medical Officer
    public function medicals():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'medical_officer', 'medical_id', 'user_id');
    }

    public function medicalCheckup():HasMany
    {
        return $this->hasMany(MedicalCheckup::class, 'medical_id');
    }
}
