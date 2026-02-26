<?php

namespace App\Repositories;

use App\Data\Invoice\CreateInvoiceDTO;
use App\Data\Invoice\FilterInvoiceDto;
use App\Data\UpdateInvoiceDTO;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function createOne(CreateInvoiceDTO $dto): Invoice
    {
        return Invoice::create($dto->toArray());
    }

    public function findMany(FilterInvoiceDto $filters): LengthAwarePaginator
    {
        $builder = Invoice::query()->with(['contract', 'payments']);
        $this->applyFilter(query: $builder, filters: $filters);

        return $builder->paginate($filters->per_page);
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

    private function applyFilter(Builder $query, FilterInvoiceDto $filters): void
    {
        if (! is_null($filters->contract_id)) {
            $query->where('contract_id', $filters->contract_id);
        }

        if (! is_null($filters->status)) {
            $query->where('status', $filters->status);
        }

        if (! is_null($filters->from_due_date)) {
            $query->whereDate('due_date', '>=', $filters->from_due_date);
        }

        if (! is_null($filters->to_due_date)) {
            $query->whereDate('due_date', '<=', $filters->to_due_date);
        }
    }
}
