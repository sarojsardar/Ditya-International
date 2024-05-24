<?php
namespace App\Data\Reports;
use App\Models\CashOuts;
use App\Models\Expenses;
use App\Models\PettyCash;

class transactionReportData{

    protected $filters;

    public function __construct($filters = []){
        $this->filters = $filters;
    }

    public function transactionReport(){

        $pettyCashes = PettyCash::whereDate('created_at', '>=', $this->filters['start_date'])
        ->whereDate('created_at', '<=', $this->filters['end_date'])->orderBy('created_at', 'desc')->get();

        $expenses = Expenses::whereDate('created_at', '>=', $this->filters['start_date'])
        ->whereDate('created_at', '<=', $this->filters['end_date'])->orderBy('created_at', 'desc')->get();

        $cashouts = CashOuts::whereDate('created_at', '>=', $this->filters['start_date'])
        ->whereDate('created_at', '<=', $this->filters['end_date'])->orderBy('created_at', 'desc')->get();

        $data['pettyCashes'] = $pettyCashes;
        $data['expenses'] = $expenses;
        $data['cashouts'] = $cashouts;

        return $data;

    }
}