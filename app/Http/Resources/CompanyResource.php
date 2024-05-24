<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'company_name' => $this->name,
            'address' => $this->address,
            'logo' => $this->logo != null ? url('storage/uploads/company-logo').'/'.$this->logo : null,
        ];
    }
}
