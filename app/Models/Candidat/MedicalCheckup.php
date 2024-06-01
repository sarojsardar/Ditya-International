<?php

namespace App\Models\Candidat;

use App\Models\CompanyDemand;
use App\Models\Medical\Medical;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalCheckup extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function candidate():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function medical():BelongsTo
    {
        return $this->belongsTo(Medical::class, 'medical_id');
    }

    public function demand():BelongsTo
    {
        return $this->belongsTo(CompanyDemand::class, 'demand_id');
    }
}
