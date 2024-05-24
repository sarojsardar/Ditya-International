<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationalDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'edu_doc' => $this->edu_doc != null ? url('storage/uploads/edu-doc').'/'.$this->edu_doc : null,
            'level' => $this->level,
            'school_college_name' => $this->school_college_name,
            'pass_year' => $this->pass_year,
        ];
    }
}
