<?php
namespace App\Data\Accounts;

use App\Enum\InvoiceStatus;
use App\Models\InvoicePayments;
use Illuminate\Http\Request;
use App\Models\CandidateInvoice;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class AccountData{

    protected $request;

    public function __construct(Request $request = null){
        $this->request = $request;
    }

    public function initiateInvoice($candidateId, $totalAmount){

        $inv = IdGenerator::generate(['table' => 'candidate_invoices', 'field' => 'invoice_no', 'length' => 12, 'prefix' =>'INV-']);

        CandidateInvoice::create([
            'invoice_no' => $inv,
            'candidate_id' => $candidateId,
            'total_payment' => $totalAmount,
            'payment_status' => InvoiceStatus::NEW 
        ]);
    }

    public function getInvoice($invoiceNo){
        return CandidateInvoice::where('invoice_no', $invoiceNo)
        ->with('payments')
        ->first();
    }

    public function getInvoiceById($invoiceId){
        return CandidateInvoice::find($invoiceId);
    }

    public function savePayment($invoiceId){
        InvoicePayments::create([
            'invoice_id' => $invoiceId,
            'paid_amount' => $this->request->collected_amount
        ]);
    }

    public function listIncompleteInvoices($demandCode){
        $invoices =  CandidateInvoice::where('payment_status', '=', InvoiceStatus::NEW)->get();
        return collect($invoices)->map(function($row) use ($demandCode){
            if($row->candidate->demand->demand_code == $demandCode){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();
    }
    public function listPartialInvoices($demandCode){
        $invoices = CandidateInvoice::where('payment_status', '=', InvoiceStatus::PARTIALL_PAYMENT)->get();
        return collect($invoices)->map(function($row) use ($demandCode){
            if($row->candidate->demand->demand_code == $demandCode){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();
    }
    public function listPaidInvoices($demandCode){
        $invoices =  CandidateInvoice::where('payment_status', '=', InvoiceStatus::FULLY_PAID)->get();
        return collect($invoices)->map(function($row) use ($demandCode){
            if($row->candidate->demand->demand_code == $demandCode){
                return $row;
            }else{
                return null;
            }
        })->whereNotNull();
    }
}