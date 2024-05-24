<?php
namespace App\Data\Accounts;
use App\Enum\ExpenseStatementStatus;
use App\Models\ExpenseStatements;
use Carbon\Carbon;

class ExpenseStatementData{

    public function find($id){
        return ExpenseStatements::find($id);
    }
    
    public function statementsToday(){
        return ExpenseStatements::whereDay('created_at', Carbon::today())->get();
    }

    public function list(){
        return ExpenseStatements::all()->sortByDesc("created_at");
    }
}