<?php

namespace App\Repositories;

use App\Data\CreateInvoiceDTO;
use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function createOne(CreateInvoiceDTO $data): Invoice;

    public function countForUpdate(): int;
}
