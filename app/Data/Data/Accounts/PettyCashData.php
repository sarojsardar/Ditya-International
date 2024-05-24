<?php
namespace App\Data\Accounts;

use App\Enum\PettyCashStatus;
use App\Models\PettyCash;
use Illuminate\Http\Request;

class PettyCashData{

    protected $request;

    public function __construct(Request $request = null){
        $this->request = $request;
    }

    public function find($id){
        return PettyCash::find($id);
    }

    public function listRequests(){
        return PettyCash::orderBy('created_at', 'desc')->get();
    }

    public function prevRequest(){
        return PettyCash::where('status', PettyCashStatus::APPROVED)
            ->where('cash_status', PettyCashStatus::ACTIVE)->first();
    }

    public function unApprovedRequest(){
        return PettyCash::where('status', PettyCashStatus::PENDING)->first();
    }

    public function listOffStatementList(){
        return PettyCash::where('status', PettyCashStatus::APPROVED)
            ->where('statement_status', PettyCashStatus::OFF_STATEMENT)
            ->orderBy('created_at', 'desc')->get();
    }

    public function findUsingArrayId($ids){
        return PettyCash::whereIn('id', $ids)->get();
    }

}