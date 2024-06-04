<?php

namespace App\Models\Candidate;

use App\Models\Company;
use App\Models\User;
use App\Models\CompanyDemand;
use App\Models\Medical\Medical;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisaProcess extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function candidate():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function demand():BelongsTo
    {
        return $this->belongsTo(CompanyDemand::class, 'demand_id');
    }
}
