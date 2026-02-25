<?php

namespace App\Repositories;

use App\Data\CreateInvoiceDTO;
use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function createOne(CreateInvoiceDTO $dto): Invoice;

    public function countForUpdate(): int;
}
