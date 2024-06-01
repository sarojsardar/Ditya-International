<?php
namespace App\Data\Datatables;

use Illuminate\Http\Request;
use App\Models\Candidat\MedicalCheckup;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DocumentAccessApidata
{
    protected $request;
    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getIncheckupCandidates($medicals)
    {
        $medical = request()->medical;
        $company = request()->company;
        $checkup_date = request()->checkup_date;
        $status = request()->status;

        $medicalIds = collect($medicals)->pluck('id')->toArray();
        $medicalCheckUps = MedicalCheckup::where([
            // This is commented due to the filter of data
            // 'is_tested'=>false,
        ])->whereIn('medical_id', $medicalIds)->orderBy('checkup_date', 'desc');

        $medicalCheckUps->when($medical, function($query, $medical){
            $query->where('medical_id', $medical);
        })->when($company, function($query, $company){
            $query->where('company_id', $company);
        })->when($checkup_date, function($query, $checkup_date){
            $checkup_date = explode('to', $checkup_date);
            $startDate = Carbon::parse($checkup_date[0]);
            $endDate = Carbon::parse($checkup_date[1] ?? $checkup_date[0])->addDay();
            $query->whereBetween('checkup_date', [$startDate, $endDate]);
        })->when($status, function($query, $status){
            if($status == "All"){
            }elseif($status == "Tested"){
                $query->where('is_tested', true);
            }else{
                $query->where('status', $status);
            }
        });

        
        return DataTables::of($medicalCheckUps)
            ->addIndexColumn()
            ->addColumn('checkup_date', function($row){
                return Carbon::parse($row->checkup_date)->format('Y-m-d g:i A');
            })
            ->addColumn('medical_status', function($row){
                $returnString = "Not Tested";
                if($row->status == "Fit"){
                    $returnString = '<span class="badge bg-primary text-white">'.$row->status.'</span>';
                }
                if($row->status == "Unfit"){
                    $returnString = '<span class="badge bg-danger text-white">'.$row->status.'</span>';
                }
                return $returnString;
            })
            ->addColumn('company_info', function($row){
                $company = $row?->demand?->new_company;
                $return_string = '
                    <div>
                        <p class="p-0 m-0">Company Name:<a href="#">'.$company?->name.'</a></p>
                        <p class="p-0 m-0">Category:'.implode(',', $company?->categories()->pluck('name')->toArray()).' </p>
                        <p class="p-0 m-0">Country: '.$company?->originCountry?->name.' </p>
                        <p class="p-0 m-0">Address: '.$company?->address.'</p>
                    </div>
                ';
                return $return_string;
            })
            ->addColumn('logo', function($row){
                $company = $row?->demand?->new_company;
                $url = url('/storage/uploads/company-logo/'. $company?->logo);
                return "<img src='{$url}' alt='company logo' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })

            ->addColumn('candidate_info', function($row){
                $candidate = '';
                if($row->candidate?->userInfo->first_name){
                    $candidate = $row->candidate?->userInfo->first_name . ' '.$row->candidate?->userInfo->middle_name.' '.$row->candidate?->userInfo->last_name;
                }else{
                    $candidate = $row->name;
                }
                $address =  ($row->candidate?->userInfo?->full_address ?? $row->candidate?->address) ?? "N/A";
                $gender =  $row->candidate?->userDetail?->gender ?? "N/A" ;
                $email = $row->candidate?->email ?? "N/A";
                $contact_no = $row->candidate?->userDetail?->contact ?? "N/A";
                $return_string = '
                    <div>
                        <p class="p-0 m-0">Name:<a href="#">'.$candidate.'</a></p>
                        <p class="p-0 m-0">Country: '.$address.' </p>
                        <p class="p-0 m-0">Gender: '.$gender.'</p>
                        <p class="p-0 m-0">Email: '.$email.'</p>
                        <p class="p-0 m-0">Email: '.$contact_no.'</p>
                    </div>
                ';
                return $return_string;
            })
            ->addColumn('profile', function($row){
                $profile =  $row->candidate?->userInfo?->profile_picture;
                $url = url('/storage/uploads/company-logo/'. $profile);
                return "<img src='{$url}' alt='Profile Picture' style='width: 80px; height: 80px; border-radius: 50%; object-fit: contain;'>";
            })
            ->addColumn('action', function($row){
                $candidate = '';
                if($row->candidate?->userInfo->first_name){
                    $candidate = $row->candidate?->userInfo->first_name . ' '.$row->candidate?->userInfo->middle_name.' '.$row->candidate?->userInfo->last_name;
                }else{
                    $candidate = $row->name;
                }
                $action = "Not Available";
                if(!(bool)$row->is_tested){
                    $action = '<div class="d-flex">
                            <a href ="#" class="m-1 btn btn-primary btn-action-status" data-value="Fit" data-medical_checkup="'.$row->id.'"  data-candidate="'.$candidate.'">Fit</a>
                            <a href ="#" class="m-1 btn btn-danger btn-action-status" data-value="Unfit" data-medical_checkup="'.$row->id.'"  data-candidate="'.$candidate.'">Unfit</a>
                    </div>';
                }
                return $action;
            })
            ->rawColumns(['DT_RowIndex', 'profile', 'candidate_info', 'medical_status', 'company_info', 'logo', 'action', 'selected'])
            ->make(true);
        }
}