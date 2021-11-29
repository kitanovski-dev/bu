<?php

namespace App\Src\Domain\Repositories\Eloquent;

use App\Src\Domain\Models\OrderStatus;
use App\Src\Domain\Repositories\AbstractRepository;

class EloquentStatusRepository extends AbstractRepository
{
    public function entity()
    {
        return OrderStatus::class;
    }

    public function create($data)
    {
        $orderStatus = [
            'order_id' => $data,
            'status' => 'pending',
        ];

        $this->entity->create($orderStatus);
    }
}
