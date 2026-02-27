<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'unit_name' => $this->unit_name,
            'customer_name' => $this->customer_name,
            'rent_amount' => $this->rent_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status?->value,
        ];
    }
}
