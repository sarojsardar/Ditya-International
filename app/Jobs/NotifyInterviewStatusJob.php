<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Company;
use App\Models\Interview;
use App\Models\UserDetail;
use App\Models\CompanyDemand;
use Illuminate\Bus\Queueable;
use App\Action\NotificationAction;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class NotifyInterviewStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $interviewsIds;
    /**
     * Create a new job instance.
     */
    public function __construct($interviewsIds)
    {
        $this->interviewsIds = $interviewsIds;
        info($this->interviewsIds);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        info("At Dispatching");
        info($this->interviewsIds);


        foreach ($this->interviewsIds as $key => $id) {
                $interview = Interview::find($id);
                info($interview);
                if($interview){ 
                    $candidate = User::where('id', $interview->user_id)->first();
                    $candidateDetail = UserDetail::where('user_id', $candidate->id)->latest()->first();
                    $candidateCode = $candidateDetail->candidate_code;
                    $demandCode = $interview->demand_code;
                    $url = env('APP_URL').'/receptionist/attend-interview?candidate='.$candidateCode.'&demand='.$demandCode;
                    $qu =  QrCode::size(500)->format('png')->generate('URL: '.$url);
                    $filename = $candidateCode.'-'.$demandCode.'.png';
                    $file = Storage::disk('public')->put('qr/'.$filename, $qu);
                    $filename = asset('storage').'/qr/'.$filename;

                    $interview->qr = $filename;
                    $interview->save();
                    $interview = $interview->refresh();


                    $demand = CompanyDemand::where('id', $interview->demand_id)->first();
                    $company = Company::where('user_id', $demand->company_id)->first();
                    $companyName = $company->name;

                    $user = User::find($interview->user_id);

                    info($user);


                    if ($interview->wasRecentlyCreated) {
                        $title = "Your Interview date and time has been Scheduled";
                    }else{
                        $title = "Your Interview date and time has been Rescheduled";
                    }
                    $generated_by = "System";
                    $generated_id = 0;
                    // This may be change according to the candidate model 
                    $generated_to = get_class($user);
                    $generated_to_id = $user->id;
                    $go_to_url = "#";
                    // in the below the href must be changed;
                    $web_content = "Namaste!</br>" .
                    "We'd like to invite you for interview :</br>" .
                    "Date: $interview->interview_date</br>" .
                    "Time: $interview->interview_time</br>" .
                    "Venue: $interview->interview_venue</br>" .
                    "Company Name: $companyName";
                    $web_content.= '</br> Please Show This QR for the Intervieew Attend</br> <p><img src="'.$interview->qr.'"></p>';
                    $web_content.= '</br> Click Here To Download</br> <p><a href="'.$interview->qr.'"></a></p>';

                    $mobile_content =  "Namaste!\n" .
                    "We'd like to invite you for interview :\n" .
                    "Date: $interview->interview_date\n" .
                    "Time: $interview->interview_time\n" .
                    "Venue: $interview->interview_venue\n" .
                    "Company Name: $companyName";
                    $is_auto = true;

                    $send_to = 1;
                    (new NotificationAction(
                        $title,
                        $web_content,
                        $mobile_content,
                        $is_auto,
                        $generated_by,
                        $generated_id,
                        $generated_to,
                        $generated_to_id,
                        $send_to,
                        $go_to_url,
                    ))->pushNotification();




                    $send_to = 2;
                    (new NotificationAction(
                        $title,
                        $web_content,
                        $mobile_content,
                        $is_auto,
                        $generated_by,
                        $generated_id,
                        $generated_to,
                        $generated_to_id,
                        $send_to,
                        $go_to_url,
                    ))->pushNotification($interview->qr); 
                }
        }
    }
}
