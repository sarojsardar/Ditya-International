<?php
namespace App\Enum;
use App\Abstracts\Enum;

class CandiateAccessEnum extends Enum{
    const IN_VISA = 'in_visa';
    const IN_DOCUMENT = 'in_document';
    const IN_MEDICAL = 'in_medical';
    const NEW_FOR_VISA = 'new_for_visa';
    const VISA_CALLING = 'visa_calling';
    const VISA_RECEIVED = 'visa_received';
    const EVISA_CALLING = 'evisa_calling';
    const EVISA_RECEIVED = 'evisa_received';
    const FINAL_APPROVAL = 'final_approval';
    const TICKETING = 'ticketing';
    const ENGAGED = 'engaged';
    const CANCELLED = "cancelled";
}