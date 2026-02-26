<?php

namespace App\Repositories;

use App\Data\CreateInvoiceDTO;
use App\Data\UpdateInvoiceDTO;
use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function createOne(CreateInvoiceDTO $dto): Invoice;

    public function getOneById(int $id): Invoice;

    public function updateOne(Invoice $invoice, UpdateInvoiceDTO $dto): Invoice;

    public function countForUpdate(): int;
}
