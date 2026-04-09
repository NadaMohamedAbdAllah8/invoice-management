<?php

namespace App\Repositories\Admin;

use App\Data\Admin\CreateTenantDTO;
use App\Data\Admin\FilterAdminDTO;
use App\Models\Admin;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

class AdminRepository implements AdminRepositoryInterface
{
    public function findOne(FilterAdminDTO $filters): ?Admin
    {
        $builder = Admin::query();
        $this->applyFilter(query: $builder, filters: $filters);

        return $builder->first();
    }

    private function applyFilter(Builder $query, FilterAdminDTO $filters): void
    {
        if (! is_null($filters->email)) {
            $query->where('email', $filters->email);
        }
    }
}
