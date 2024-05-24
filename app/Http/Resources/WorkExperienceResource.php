<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'address' => $this->address,
            'company_name' => $this->company_name,
            'position' => $this->position,
            'description' => $this->description,
            'country' => $this->country,
            'no_of_years' => $this->no_of_years,
        ];
    }
}
