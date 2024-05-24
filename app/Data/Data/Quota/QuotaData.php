<?php
namespace App\Data\Quota;

use App\Models\QuotaAllotment;
use Illuminate\Http\Request;

class QuotaData {

    protected $request;

    public function __construct(Request $request = null){
        $this->request = $request;
    }

    public function storeQuota(){

        $existed = $this->checkPrevAllotment($this->request->demand_id, $this->request->pro_id);
        if($existed){
            $existed->update([
                'allotted_quota' => ($existed->allotted_quota + $this->request->allotted_quota),
            ]);
        }else{
            QuotaAllotment::create([
                'demand_id' => $this->request->demand_id,
                'pro_id' => $this->request->pro_id,
                'allotted_quota' => $this->request->allotted_quota,
            ]);
        }
    }

    public function deductQuota($demand, $value){
        $demand->update([
            "remaining_quota" => ($demand->remaining_quota - $value),
        ]);
    }

    public function fetchProQuotaOnDemand($demand_id, $pro_id){
        return QuotaAllotment::where('demand_id', $demand_id)->where('pro_id', $pro_id)->first();
    }

    public function checkPrevAllotment($demand_id, $pro_id){
        $existed = QuotaAllotment::where('demand_id', $demand_id)->where('pro_id', $pro_id)->first();
        return $existed;
    }

    public function checkProQuotaValue($demand_id, $pro_id){
        return QuotaAllotment::where('demand_id', $demand_id)->where('pro_id', $pro_id)->pluck('allotted_quota')->first();
    }

}