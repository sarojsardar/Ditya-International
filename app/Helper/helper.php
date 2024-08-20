<?php

use App\Models\UserDetail;

if(!function_exists('generateCandidatecode')){
    function generateCandidatecode()
    {
        $userDetail = UserDetail::latest()->first();
        if (!$userDetail || !$userDetail->candidate_code) {
            // If no previous candidate code exists, start with '00000001'
            $candidateCode = '00000001';
        } else {
            // Extract the numeric part of the candidate code and increment it
            $prevCandidateCode = $userDetail->candidate_code;
            $numericPart = intval($prevCandidateCode);
            $newNumericPart = $numericPart + 1;

            // Pad the new numeric part with leading zeros to maintain 8 characters
            $candidateCode = str_pad($newNumericPart, 8, '0', STR_PAD_LEFT);
        }

        return $candidateCode;
    }
}