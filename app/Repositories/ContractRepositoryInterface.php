<?php

namespace App\Repositories;

use App\Data\CreateContractDTO;
use App\Models\Contract;

interface ContractRepositoryInterface
{
    public function createOne(CreateContractDTO $dto): Contract;

    public function getOneById(int $id): Contract;
}
