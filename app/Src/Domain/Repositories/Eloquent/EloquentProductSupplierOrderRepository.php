<?php

namespace App\Src\Domain\Repositories\Eloquent;

use App\Src\Domain\Models\ProductSupplierOrder;
use App\Src\Domain\Repositories\AbstractRepository;

class EloquentProductSupplierOrderRepository extends AbstractRepository
{
    public function entity()
    {
        return ProductSupplierOrder::class;
    }

    public function create($data)
    {
       return $this->entity->create($data);
    }
}
