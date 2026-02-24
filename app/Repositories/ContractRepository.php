<?php

namespace App\Repositories;

use App\Data\CreateContractDTO;
use App\Models\Contract;

class ContractRepository implements ContractRepositoryInterface
{
    public function createOne(CreateContractDTO $data): Contract
    {
        return Contract::create($data->toArray());
    }
}
