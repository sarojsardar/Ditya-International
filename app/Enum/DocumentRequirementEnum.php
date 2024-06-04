<?php
namespace App\Enum;

use App\Abstracts\Enum;

class DocumentRequirementEnum extends Enum
{
    const PROFILE_PICTURE = 1;
    const PP_SIZE_PHOTO = 2;
    const PASSPORT = 3;
    const FULL_SIZE_PHOTO = 4;
    const EDUCATIONAL_DOCUMENT = 5;
    const RESUME = 6;
    const ADDITIONAL_DOCUMENT = 7;
}