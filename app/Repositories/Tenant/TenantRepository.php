<?php

namespace App\Repositories\Tenant;

use App\Data\Admin\CreateTenantDTO;
use App\Data\Admin\UpdateTenantDTO;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Collection;

class TenantRepository implements TenantRepositoryInterface
{
    public function getAll(): Collection
    {
        return Tenant::query()
            ->with(['invoices.payments'])
            ->get();
    }

    public function createOne(CreateTenantDTO $dto): Tenant
    {
        return Tenant::query()->create($dto->toArray());
    }

    public function getOneById(int $id): Tenant
    {
        return Tenant::query()
            ->with(['invoices.payments'])
            ->findOrFail($id);
    }

    public function updateOne(Tenant $tenant, UpdateTenantDTO $dto): Tenant
    {
        $tenant->update($dto->toArray());

        return $tenant->refresh()->load(['invoices.payments']);
    }
}
