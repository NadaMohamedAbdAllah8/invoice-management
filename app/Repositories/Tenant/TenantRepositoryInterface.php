<?php

namespace App\Repositories\Tenant;

use App\Data\Admin\CreateTenantDTO;
use App\Data\Admin\UpdateTenantDTO;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Collection;

interface TenantRepositoryInterface
{
    public function getAll(): Collection;

    public function createOne(CreateTenantDTO $dto): Tenant;

    public function getOneById(int $id): Tenant;

    public function updateOne(Tenant $tenant, UpdateTenantDTO $dto): Tenant;
}
