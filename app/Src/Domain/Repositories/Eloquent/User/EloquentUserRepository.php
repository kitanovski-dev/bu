<?php

namespace App\Src\Domain\Repositories\Eloquent\User;

use App\Src\Domain\Models\User;
use App\Src\Domain\Repositories\AbstractRepository;

class EloquentUserRepository extends AbstractRepository
{
    public function entity()
    {
        return User::class;
    }
}
