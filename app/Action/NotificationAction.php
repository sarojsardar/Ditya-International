<?php
namespace App\Action;

use App\Enum\NotificationSendEnum;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Models\Notification\Notification;
use Illuminate\Support\Facades\Log;

class NotificationAction
{
    protected $title;
    protected $web_content;
    protected $mobile_content;
    protected $is_auto;
    protected $generated_by;
    protected $generated_id;
    protected $generated_to;
    protected $generated_to_id;
    protected $send_to;
    protected $go_to_url;
    protected $content_type;
    protected $document_process_id;
    function __construct(
        $title,
        $web_content=null, 
        $mobile_content=null, 
        $is_auto=true,
        $generated_by="System",
        $generated_id=0,
        $generated_to="System",
        $generated_to_id = 0,
        $send_to = 4,
        $go_to_url = "#",
        $content_type = 'normal',
        $document_process_id = null
    )
    {
        $this->title = $title;
        $this->web_content = $web_content;
        $this->mobile_content = $mobile_content;
        $this->is_auto = $is_auto;
        $this->generated_by = $generated_by;
        $this->generated_id = $generated_id;
        $this->generated_to = $generated_to;
        $this->generated_to_id = $generated_to_id;
        $this->send_to = $send_to;
        $this->go_to_url = $go_to_url;
        $this->content_type = $content_type;
        $this->document_process_id = $document_process_id;
    }
    private function pushToSms()
    {
        if((int)$this->send_to == NotificationSendEnum::SMS || (int)$this->send_to == NotificationSendEnum::ALL){
            if($this->generated_to !== "System"){
                $receiver = $this->generated_to::where('id', $this->generated_by)->first();
                if($receiver){
                    if($receiver->mobile_no){
                        SendSmsJob::dispatch($this->mobile_content, $receiver->mobile_no);
                    }
                }
            }
        }
    }
    private function pushToEmail()
    {
        if((int)$this->send_to == NotificationSendEnum::EMIAL ||  (int)$this->send_to == NotificationSendEnum::ALL){
            if($this->generated_to !== "System"){
                $receiver = $this->generated_to::where('id', $this->generated_by)->first();
                if($receiver){
                    if($receiver->email){
                        SendEmailJob::dispatch($this->mobile_content, $receiver->email, $this->title);
                    }
                }
            }
        }
    }
    private function pushToSystem()
    {
        if((int)$this->send_to == NotificationSendEnum::SYSTEM || (int)$this->send_to == NotificationSendEnum::ALL){
            
        }
    }
    public function pushNotification()
    {
        try {
            if($this->web_content || $this->mobile_content){
                $notification = Notification::create([
                    'title'=>$this->title,
                    'generated_by'=>$this->generated_by,
                    'generated_id'=>$this->generated_id,
                    'generated_to'=>$this->generated_to,
                    'generated_to_id'=>$this->generated_to_id,
                    'web_content'=>$this->web_content,
                    'mobile_content'=>$this->mobile_content,
                    'is_auto'=>$this->is_auto ?? true,
                    'send_to'=>$this->send_to,
                    'go_to_url'=>$this->go_to_url ?? "#",
                    'content_type'=>$this->content_type,
                    'document_process_id'=>$this->document_process_id,
                ]);

                $this->pushToSms();
                $this->pushToEmail();
                $this->pushToSystem();
            }   
        } catch (\Throwable $th) {
            info("Error While Notifying");
            info($th->getMessage());
        }
    }
}