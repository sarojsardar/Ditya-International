<?php
namespace App\Data\Candidate;

use App\Models\User;
use App\Enum\UserTypes;
use App\Models\CompanyDemand;
use App\Enum\UserDemandStatus;
class CompanyCandidateData
{
    function __construct()
    {
        
    }

    public function getWishListCandidate($demandCode)
    {
        $companyDemand = CompanyDemand::where('demand_code', $demandCode)->firstOrFail(); // Directly abort if not found
        $demandId = $companyDemand->id; // Use this directly

        $filteredUsers = User::where('user_type', UserTypes::CANDIDATE)
            ->whereHas('candidateCompany', function ($query) {
                $query->where('demand_status', UserDemandStatus::Approved);
            })
            ->whereHas('candidateCompany', function ($query) use ($demandId) {
                $query->where('demand_id', $demandId);
            })
            ->get();
        return $filteredUsers;
    }
}