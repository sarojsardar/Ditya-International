<?php
namespace App\Action;

use App\Enum\NotificationSendEnum;
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
        $go_to_url = "#"
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
    }
    private function pushToSms()
    {
        if((int)$this->send_to == NotificationSendEnum::SMS){

        }
    }
    private function pushToEmail()
    {
        if((int)$this->send_to == NotificationSendEnum::EMIAL){

        }
    }
    private function pushToSystem()
    {
        if((int)$this->send_to == NotificationSendEnum::SYSTEM){

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