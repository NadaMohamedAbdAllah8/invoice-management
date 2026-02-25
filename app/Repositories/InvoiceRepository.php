<?php

namespace App\Repositories;

use App\Data\CreateInvoiceDTO;
use App\Models\Invoice;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function createOne(CreateInvoiceDTO $data): Invoice
    {
        return Invoice::create([
            'contract_id' => $data->contract_id,
            'invoice_number' => $data->invoice_number,
            'subtotal' => $data->subtotal,
            'tax_amount' => $data->tax_amount,
            'total' => $data->total,
            'status' => $data->status,
            'due_date' => $data->due_date,
            'paid_at' => $data->paid_at,
        ]);
    }

    public function countForUpdate(): int
    {
        return Invoice::query()
            ->lockForUpdate()
            ->count();
    }
}
