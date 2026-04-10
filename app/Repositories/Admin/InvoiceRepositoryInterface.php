<?php

namespace App\Repositories\Admin;

use App\Data\Invoice\FilterInvoiceDto;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface InvoiceRepositoryInterface
{
    public function findMany(FilterInvoiceDto $filters): Builder;

    public function paginate(Builder $builder, int $perPage, int $page): LengthAwarePaginator;

    public function get(Builder $builder): Collection;

    public function getOneById(int $id): Invoice;
}
