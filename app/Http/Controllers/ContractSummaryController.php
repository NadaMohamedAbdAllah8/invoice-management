<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContractSummaryResource;
use App\Models\Contract;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class ContractSummaryController extends Controller
{
    use RespondsWithJson;

    public function __invoke(Contract $contract): JsonResponse
    {
        return $this->returnItemWithSuccessMessage(
            item: new ContractSummaryResource($contract->load('invoices.payments')),
            message: 'Contract summary fetched successfully',
        );
    }
}
