<?php

namespace App\Repositories\User;

use App\Data\User\FilterUserDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function findOne(FilterUserDTO $filters): ?User;
}
