<?php

namespace App\Repositories;

use App\Data\Invoice\CreateInvoiceDTO;
use App\Data\Invoice\FilterInvoiceDto;
use App\Data\UpdateManyInvoicesDTO;
use App\Data\UpdateInvoiceDTO;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface InvoiceRepositoryInterface
{
    public function createOne(CreateInvoiceDTO $dto): Invoice;

    public function findMany(FilterInvoiceDto $filters): Builder;

    public function paginate(Builder $builder, int $perPage, int $page): LengthAwarePaginator;

    public function get(Builder $builder): Collection;

    public function getOneById(int $id): Invoice;

    public function updateOne(Invoice $invoice, UpdateInvoiceDTO $dto): Invoice;

    public function updateMany(UpdateManyInvoicesDTO $dto, Collection $invoices): int;

    public function countForUpdate(): int;
}
