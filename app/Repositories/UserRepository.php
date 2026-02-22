<?php

namespace App\Repositories;

use App\Data\User\FilterUserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository implements UserRepositoryInterface
{
    public function findOne(FilterUserDTO $filters): ?User
    {
        $builder = User::query();
        $this->applyFilter(query: $builder, filters: $filters);

        return $builder->first();
    }

    private function applyFilter(Builder $query, FilterUserDTO $filters): void
    {
        if (! is_null($filters->email)) {
            $query->where('email', $filters->email);
        }
    }
}
