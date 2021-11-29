<?php

namespace App\Src\Domain\Repositories\Eloquent;

use App\Src\Domain\Models\SupplierOrder;
use App\Src\Domain\Repositories\AbstractRepository;

class EloquentSupplierOrderRepository extends AbstractRepository
{
    public function entity()
    {
        return SupplierOrder::class;
    }

    public function create($data)
    {
        
    }
}
