<?php

namespace App\Services;

use App\Data\CreateContractDTO;
use App\Models\Contract;
use App\Repositories\Contract\ContractRepositoryInterface;

class ContractService
{
    public function __construct(private ContractRepositoryInterface $contractRepository) {}

    public function createOne(CreateContractDTO $dto): Contract
    {
        return $this->contractRepository->createOne(dto: $dto);
    }
}
