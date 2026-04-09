<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\PaymentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'contract_id' => $this->contract_id,
            'invoice_number' => $this->invoice_number,
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax_amount,
            'total' => $this->total,
            'remaining_balance' => $this->remaining_balance,
            'status' => $this->status?->value,
            'due_date' => $this->due_date,
            'paid_at' => $this->paid_at,
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
