<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractSummaryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'invoices_count' => $this->invoices_count,
            'total_invoiced' => $this->total_invoiced,
            'total_paid' => $this->total_paid,
            'outstanding_balance' => $this->outstanding_balance,
            'latest_invoice_date' => $this->latest_invoice_date,
        ];
    }
}
