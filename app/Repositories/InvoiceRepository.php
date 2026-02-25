<?php

namespace App\Repositories;

use App\Data\CreateInvoiceDTO;
use App\Models\Invoice;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function createOne(CreateInvoiceDTO $dto): Invoice
    {
        return Invoice::create($dto->toArray());
    }

    public function countForUpdate(): int
    {
        return Invoice::query()
            ->lockForUpdate()
            ->count();
    }
}
