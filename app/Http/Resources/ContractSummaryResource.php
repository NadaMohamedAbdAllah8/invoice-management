<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractSummaryResource extends JsonResource
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
            'is_active' => $this->is_active,
            'invoices_count' => $this->invoices_count,
            'total_invoiced' => $this->total_invoiced,
            'total_paid' => $this->total_paid,
            'outstanding_balance' => $this->outstanding_balance,
            'latest_invoice_date' => $this->latest_invoice_date,
            'invoices' => ContactInvoiceResource::collection($this->whenLoaded('invoices')),
        ];
    }
}
