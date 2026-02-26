<?php

namespace App\Repositories;

use App\Data\CreateInvoiceDTO;
use App\Data\UpdateInvoiceDTO;
use App\Models\Invoice;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function createOne(CreateInvoiceDTO $dto): Invoice
    {
        return Invoice::create($dto->toArray());
    }

    public function getOneById(int $id): Invoice
    {
        return Invoice::query()->findOrFail($id);
    }

    public function updateOne(Invoice $invoice, UpdateInvoiceDTO $dto): Invoice
    {
        $invoice->update($dto->toArray());

        return $invoice->refresh();
    }

    public function countForUpdate(): int
    {
        return Invoice::query()
            ->lockForUpdate()
            ->count();
    }
}
