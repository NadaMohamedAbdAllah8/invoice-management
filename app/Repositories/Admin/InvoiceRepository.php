<?php

namespace App\Repositories\Admin;

use App\Models\Invoice;
use App\Repositories\Invoice\InvoiceRepository as BaseInvoiceRepository;
use App\Tenancy\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Builder;

class InvoiceRepository extends BaseInvoiceRepository implements InvoiceRepositoryInterface
{
    protected function baseQuery(): Builder
    {
        return Invoice::query()
            ->withoutGlobalScope(TenantScope::class);
    }
}
