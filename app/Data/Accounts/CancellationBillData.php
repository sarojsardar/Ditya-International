<?php
namespace App\Data\Accounts;

use App\Data\CompanyDemand\CompanyDemandData;
use App\Enum\CancellationStatus;
use App\Models\CancelBills;
use App\Models\CancellationRates;

class CancellationBillData{

    public function charge($stage){
        return CancellationRates::where('stage', $stage)->pluck('rate')->first();
    }

    public function find($id){
        return CancelBills::find($id);
    }

    public function getCancelledPendingBills($demandId){
        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if(@$row->cancellationBill){
                if($row->cancellationBill->status == CancellationStatus::NEW){
                    return $row;
                }else{
                    return null;
                }
            }else{
                return null;
            }
        })->whereNotNull();
        return $candidates;
    }
    public function getCancelledPaidBills($demandId){
        $demand = (new CompanyDemandData())->getDemand($demandId);

        $candidates = collect($demand->candidates)->map(function($row){
            if(@$row->cancellationBill){
                if($row->cancellationBill->status == CancellationStatus::BILL_PAID){
                    return $row;
                }else{
                    return null;
                }
            }else{
                return null;
            }
        })->whereNotNull();
        return $candidates;
    }
}