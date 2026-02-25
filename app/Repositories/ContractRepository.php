<?php

namespace App\Repositories;

use App\Data\CreateContractDTO;
use App\Models\Contract;

class ContractRepository implements ContractRepositoryInterface
{
    public function createOne(CreateContractDTO $dto): Contract
    {
        return Contract::create($dto->toArray());
    }

    public function getOneById(int $id): Contract
    {
        return Contract::findOrFail($id);
    }
}
