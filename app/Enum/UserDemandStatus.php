<?php
namespace App\Enum;
use App\Abstracts\Enum;

class UserDemandStatus extends Enum{

    const New = 'New';

    const Pending = 'Pending';

    const Rejected = 'Rejected';

    const Approved = 'Approved';

    const Interview = 'Interview';

}
