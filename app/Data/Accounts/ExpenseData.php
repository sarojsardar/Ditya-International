<?php
namespace App\Data\Accounts;
use App\Enum\ExpenseStatus;
use App\Models\Expenses;

class ExpenseData{


    public function find($id){
        return Expenses::find($id);
    }
    
    public function recentExpenses(){
        return Expenses::where('statement_status', ExpenseStatus::OFF_STATEMENT)->orderBy('created_at', 'desc')->get();
    }

    public function findUsingArrayId($ids){
        return Expenses::whereIn('id', $ids)->get();
    }
}