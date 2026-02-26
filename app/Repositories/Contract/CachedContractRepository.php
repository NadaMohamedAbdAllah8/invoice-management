<?php

namespace App\Repositories\Contract;

use App\Data\CreateContractDTO;
use App\Models\Contract;
use Illuminate\Support\Facades\Cache;

class CachedContractRepository implements ContractRepositoryInterface
{
    const CACHE_TTL_MINUTES = 5;

    public function __construct(
        private ContractRepositoryInterface $repository
    ) {}

    public function getOneById(int $id): Contract
    {
        $key = $this->contractCacheKey($id);

        return Cache::remember($key, now()->addMinutes(self::CACHE_TTL_MINUTES), function () use ($id): Contract {
            return $this->repository->getOneById($id);
        });
    }

    public function createOne(CreateContractDTO $dto): Contract
    {
        return $this->repository->createOne(dto: $dto);
    }

    private function contractCacheKey(int $id): string
    {
        return "contracts:{$id}";
    }
}
