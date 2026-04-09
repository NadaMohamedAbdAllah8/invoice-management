<?php

namespace App\Http\Controllers\Admin;

use App\Data\Admin\CreateTenantDTO;
use App\Data\Admin\UpdateTenantDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateTenantRequest;
use App\Http\Requests\Admin\UpdateTenantRequest;
use App\Http\Resources\Admin\TenantResource;
use App\Models\Tenant;
use App\Services\TenantService;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class TenantController extends Controller
{
    use RespondsWithJson;

    public function __construct(private TenantService $tenantService) {}

    public function index(): JsonResponse
    {
        $tenants = $this->tenantService->getAll();

        return $this->returnItemsWithSuccessMessage(
            items: TenantResource::collection($tenants),
            message: 'Tenants fetched successfully'
        );
    }

    public function store(CreateTenantRequest $request): JsonResponse
    {
        $dto = CreateTenantDTO::fromRequest($request);
        $tenant = $this->tenantService->createOne($dto);

        return $this->returnItemWithSuccessMessage(
            item: new TenantResource($tenant),
            message: 'Tenant created successfully'
        );
    }

    public function show(Tenant $tenant): JsonResponse
    {
        $tenant = $this->tenantService->getOneById($tenant->id);

        return $this->returnItemWithSuccessMessage(
            item: new TenantResource($tenant),
            message: 'Tenant fetched successfully'
        );
    }

    public function update(UpdateTenantRequest $request, Tenant $tenant): JsonResponse
    {
        $dto = UpdateTenantDTO::fromRequest($request);
        $updatedTenant = $this->tenantService->updateOne($tenant, $dto);

        return $this->returnItemWithSuccessMessage(
            item: new TenantResource($updatedTenant),
            message: 'Tenant updated successfully'
        );
    }
}
