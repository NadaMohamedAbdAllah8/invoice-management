<?php

namespace App\Repositories;

use App\Data\Invoice\CreateInvoiceDTO;
use App\Data\Invoice\FilterInvoiceDto;
use App\Data\UpdateInvoiceDTO;
use App\Models\Invoice;
use Illuminate\Pagination\LengthAwarePaginator;

interface InvoiceRepositoryInterface
{
    public function createOne(CreateInvoiceDTO $dto): Invoice;

    public function findMany(FilterInvoiceDto $filters): LengthAwarePaginator;

    public function getOneById(int $id): Invoice;

    public function updateOne(Invoice $invoice, UpdateInvoiceDTO $dto): Invoice;

    public function countForUpdate(): int;
}
