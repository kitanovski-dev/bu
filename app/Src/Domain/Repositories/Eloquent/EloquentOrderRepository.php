<?php

namespace App\Src\Domain\Repositories\Eloquent;

use App\Src\Domain\Models\Order;
use App\Src\Domain\Repositories\AbstractRepository;

class EloquentOrderRepository extends AbstractRepository
{
    public function entity()
    {
        return Order::class;
    }

    public function create($data)
    {
        /** Write in order table */
        $orderData['order_number'] = $data->orderNumber;
        
        $order = request()->user()->order()->create($orderData);

        return $order;
    }
}