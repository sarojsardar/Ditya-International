<?php
namespace App\Data\Reports;

use App\Models\Candidate;
use App\Models\CandidateInvoice;
use App\Models\CompanyDemand;
use App\Models\InvoicePayments;
use App\Models\User;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Constraint\IsEmpty;

class ReportData {

    protected $filters;

    public function __construct($filters = []){
        $this->filters = $filters;
    }

    public function staffFilter(){

        $staffs = User::orderBy('created_at', 'desc')->whereHas('roles', function($q1){
                    $q1->where('name', '!=', 'CEO');
                    $q1->where('name', '!=', 'Company');
                })
                ->when(Arr::get($this->filters, 'start_date'), function($q2){
                    $q2->whereDate('created_at', '>=', $this->filters['start_date']);
                })
                ->when(Arr::get($this->filters, 'end_date'), function($q3){
                    $q3->whereDate('created_at', '<=', $this->filters['end_date']);
                })
                ->get();
        return $staffs;
    }

    public function companyFilter(){
        $companies = User::orderBy('created_at', 'desc')->whereHas('roles', function($q1){
                    $q1->where('name', '=', 'Company');
                })
                ->when(Arr::get($this->filters, 'company_id'), function($q4){
                    $q4->whereHas('companyInfo', function ($q5){
                        $q5->where('id', Arr::get($this->filters, 'company_id'));
                    });
                })
                ->when(Arr::get($this->filters, 'start_date'), function($q2){
                    $q2->whereDate('created_at', '>=', $this->filters['start_date']);
                })
                ->when(Arr::get($this->filters, 'end_date'), function($q3){
                    $q3->whereDate('created_at', '<=', $this->filters['end_date']);
                })
                ->when(Arr::get($this->filters, 'demand'), function($q4){
                    $q4->whereHas('companyInfo.demandDetail', function($q5){
                        $q5->where('id', Arr::get($this->filters, 'demand'));
                    });  
                })
                ->get();
        return $companies;        
    }

    public function demandFilter(){
        $demands = CompanyDemand::orderBy('created_at', 'desc')
                    ->when(Arr::get($this->filters, 'start_date'), function($q2){
                        $q2->whereDate('created_at', '>=', $this->filters['start_date']);
                    })
                    ->when(Arr::get($this->filters, 'end_date'), function($q3){
                        $q3->whereDate('created_at', '<=', $this->filters['end_date']);
                    })
                    ->when(Arr::get($this->filters, 'company_id'), function($q1){
                        $q1->whereHas('company',function($q7) {
                            $q7->where('id', Arr::get($this->filters, 'company_id'));
                        });
                    })
                    ->when(Arr::get($this->filters, 'demand'), function($q4){
                        $q4->where('id', Arr::get($this->filters, 'demand'));
                    })
                    ->get();
        return $demands;            

    }

    public function candidateFilter(){
        $candidates = Candidate::orderBy('created_at', 'desc')
                    ->when(Arr::get($this->filters, 'start_date'), function($q2){
                        $q2->whereDate('created_at', '>=', $this->filters['start_date']);
                    })
                    ->when(Arr::get($this->filters, 'end_date'), function($q3){
                        $q3->whereDate('created_at', '<=', $this->filters['end_date']);
                    })
                    ->when(Arr::get($this->filters, 'pro_id'), function ($q){
                        $q->where('pro_id', Arr::get($this->filters, 'pro_id'));
                    })
                    ->when(Arr::get($this->filters, 'company_id'), function($q4){
                        $q4->whereHas('demand', function($q5){
                            $q5->whereHas('company', function($q6){
                                $q6->where('id', Arr::get($this->filters, 'company_id'));
                            });
                        });
                    })
                    ->when(Arr::get($this->filters, 'demand'), function($q4){
                        $q4->whereHas('demand', function($q5){
                            $q5->where('id', Arr::get($this->filters, 'demand'));
                        });  
                    })
                    ->get();

        return $candidates;
    }

    public function paymentFilter(){
        $payments = InvoicePayments::orderBy('created_at', 'desc')
            ->when(Arr::get($this->filters, 'start_date'), function ($q1){
                $q1->whereDate('created_at', '>=', $this->filters['start_date']);
            })
            ->when(Arr::get($this->filters, 'end_date'), function ($q2){
                $q2->whereDate('created_at', '<=', $this->filters['end_date']);
            })
            ->when(Arr::get($this->filters, 'pro_id'), function($q3){
                $q3->whereHas('invoice.candidate', function($q4){
                    $q4->where('pro_id', Arr::get($this->filters,'pro_id'));
                });
            })
            ->when(Arr::get($this->filters, 'company_id'), function($q4){
                $q4->whereHas('invoice.candidate.demand.company', function($q5){
                    $q5->where('id', Arr::get($this->filters, 'company_id'));
                });  
            })
            ->when(Arr::get($this->filters, 'demand'), function($q4){
                $q4->whereHas('invoice.candidate.demand', function($q5){
                    $q5->where('id', Arr::get($this->filters, 'demand'));
                });  
            })->get();
        
        return $payments;            
    }
}