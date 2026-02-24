<?php

namespace App\Http\Controllers;

use App\Data\CreateContractDTO;
use App\Http\Requests\CreateContractRequest;
use App\Http\Resources\ContractResource;
use App\Services\ContractService;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class ContractController extends Controller
{
    use RespondsWithJson;

    public function __construct(private ContractService $contractService) {}

    public function store(CreateContractRequest $request): JsonResponse
    {
        $createContractDto = CreateContractDTO::fromRequest(request: $request);

        $contract = $this->contractService->createOne(dto: $createContractDto);

        return $this->returnItemWithSuccessMessage(
            item: new ContractResource($contract),
            message: 'Contract created successfully'
        );
    }
}
