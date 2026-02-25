<?php

namespace App\Repositories;

use App\Data\CreateContractDTO;
use App\Models\Contract;

interface ContractRepositoryInterface
{
    public function createOne(CreateContractDTO $data): Contract;

    public function getOneById(int $id): Contract;
}
