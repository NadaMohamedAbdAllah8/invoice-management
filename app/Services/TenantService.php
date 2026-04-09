<?php

namespace App\Services;

use App\Data\Admin\CreateTenantDTO;
use App\Data\Admin\UpdateTenantDTO;
use App\Models\Tenant;
use App\Repositories\Tenant\TenantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TenantService
{
    public function __construct(private TenantRepositoryInterface $tenantRepository) {}

    public function getAll(): Collection
    {
        return $this->tenantRepository->getAll();
    }

    public function createOne(CreateTenantDTO $dto): Tenant
    {
        return $this->tenantRepository->createOne($dto);
    }

    public function getOneById(int $id): Tenant
    {
        return $this->tenantRepository->getOneById($id);
    }

    public function updateOne(Tenant $tenant, UpdateTenantDTO $dto): Tenant
    {
        return $this->tenantRepository->updateOne($tenant, $dto);
    }
}
