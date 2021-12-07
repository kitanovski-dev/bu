<?php

namespace App\Src\Domain\Repositories\Eloquent;

use App\Src\Domain\Models\SupplierOrderLog;
use App\Src\Domain\Repositories\AbstractRepository;

class EloquentSupplierOrderLogRepository extends AbstractRepository
{
    public function entity()
    {
        return SupplierOrderLog::class;
    }

    public function create($data)
    {
       return $this->entity->create($data);
    }
}
