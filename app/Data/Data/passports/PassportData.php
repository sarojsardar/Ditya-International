<?php
namespace App\Data\passports;
use App\Data\CompanyDemand\CompanyDemandData;
use App\Enum\PassportInStatus;
use App\Enum\PassportOutStatus;
use App\Models\Candidate;
use App\Models\PassportIn;
use App\Models\PassportOuts;

class PassportData{

    public function find($id){
        return PassportIn::find($id);
    }

    public function findPassportOut($id){
        return PassportOuts::find($id);
    }

    public function getCollectablePassports($demandId){
        
        $demand = (new CompanyDemandData())->getDemand($demandId);

        $passports = collect($demand->candidates)->map(function($row){
            if(@$row->passportIn){
                if($row->passportIn->status == PassportInStatus::NEW){
                    return $row;
                }else{
                    return null;
                }
            }else{
                return null;
            }
        })->whereNotNull();
        return $passports;
    }

    public function getForwardedPassports($demandId){
        
        $demand = (new CompanyDemandData())->getDemand($demandId);

        $passports = collect($demand->candidates)->map(function($row){
            if(@$row->passportIn){
                if($row->passportIn->status == PassportInStatus::FORWARD_PASSPORT){
                    return $row;
                }else{
                    return null;
                }
            }else{
                return null;
            }
        })->whereNotNull();
        return $passports;
    }
    public function getCollectedPassports($demandId){
        if(auth('web')->user()->hasRole(['Receptionist'])){
            $passports = auth('web')->user()->innedPassports;
            return collect($passports)->map(function($row) use ($demandId){
                if($row->candidate->demand_id == $demandId){
                    if(@$row->status == PassportInStatus::RECEIVED_BY_RECEPTION || @$row->status == PassportInStatus::FORWARD_PASSPORT){
                        return $row;
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
            })->whereNotNull();

        }elseif(auth('web')->user()->hasRole(['Document-Officer'])){
            $passports = auth('web')->user()->confirmedInPassports;
            return collect($passports)->map(function($row) use ($demandId){
                if($row->candidate->demand_id == $demandId){
                    if(@$row->status == PassportInStatus::RECEIVED_BY_DOCUMENT_OFFICER){
                        return $row;
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
            })->whereNotNull();
        }else{
            $passports = [];
        }
    }
    public function getCollectedConfirmedPassports($demandId){
        if(auth('web')->user()->hasRole(['Receptionist'])){
            $passports = auth('web')->user()->innedPassports;
            return collect($passports)->map(function($row) use ($demandId){
                if($row->candidate->demand_id == $demandId){
                    if(@$row->status == PassportInStatus::RECEIVED_BY_DOCUMENT_OFFICER){
                        return $row;
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
            })->whereNotNull();
        }else{
            return $passports = [];
        }
    }

    public function getDistributablePassports($demandId){
        $passports = PassportOuts::where('status', PassportOutStatus::NEW)->orWhere('status', PassportOutStatus::RECEIVED_BY_DOCUMENT_OFFICER)->get();
        $passports = collect($passports)->map(function($row) use ($demandId){
            if($row->candidate->demand_id == $demandId){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();
        return $passports;
    }

    public function getForwardedOutPassports($demandId){
        if(auth('web')->user()->hasRole(['Document-Officer'])){
            $passports = PassportOuts::where('status', PassportOutStatus::FORWARD_PASSPORT)
            ->where('doc_officer_id', auth('web')->id())
            ->get();
        }elseif(auth('web')->user()->hasRole(['Receptionist'])){
            $passports = PassportOuts::where('status', PassportOutStatus::FORWARD_PASSPORT)->get();
        }
        $passports = collect($passports)->map(function($row) use ($demandId){
            if($row->candidate->demand_id == $demandId){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();
        return $passports;
    }
    public function getOutConfirmedPassports($demandId){
        if(auth('web')->user()->hasRole(['Document-Officer'])){
            $passports = PassportOuts::where('status', PassportOutStatus::RECEIVED_BY_RECEPTION)
            ->where('doc_officer_id', auth('web')->id())
            ->get();
        }elseif(auth('web')->user()->hasRole(['Receptionist'])){
            $passports = PassportOuts::where('status', PassportOutStatus::RECEIVED_BY_RECEPTION)
            ->where('reception_id', auth('web')->id())
            ->get();
        }
        $passports = collect($passports)->map(function($row) use ($demandId){
            if($row->candidate->demand_id == $demandId){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();
        return $passports;
    }
    public function receptionDistributedPassport($demandId){
        if(auth('web')->user()->hasRole(['Document-Officer'])){
            $passports = PassportOuts::where('status', PassportOutStatus::DELIVERED_TO_CANDIDATE)
            ->where('doc_officer_id', auth('web')->id())
            ->get();
        }elseif(auth('web')->user()->hasRole(['Receptionist'])){
            $passports = PassportOuts::where('status', PassportOutStatus::DELIVERED_TO_CANDIDATE)
            ->where('reception_id', auth('web')->id())
            ->get();
        }
        $passports = collect($passports)->map(function($row) use ($demandId){
            if($row->candidate->demand_id == $demandId){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();
        return $passports;
    }
}