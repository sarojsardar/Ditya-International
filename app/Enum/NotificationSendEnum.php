<?php
namespace App\Enum;

use App\Abstracts\Enum;

class NotificationSendEnum extends Enum
{
    const SYSTEM=1;
    const EMIAL=2;
    const SMS=3;
    const ALL=4;
}