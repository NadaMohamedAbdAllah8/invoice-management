<?php

namespace App\Repositories\Admin;

use App\Data\Admin\FilterAdminDTO;
use App\Models\Admin;

interface AdminRepositoryInterface
{
    public function findOne(FilterAdminDTO $filters): ?Admin;
}
