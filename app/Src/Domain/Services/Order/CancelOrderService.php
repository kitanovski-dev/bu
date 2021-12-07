<?php

namespace App\Src\Domain\Services\Order;

use App\App\Domain\Suppiers\SupplierInterface;
use App\Src\Domain\Repositories\Eloquent\EloquentOrderRepository;

class CancelOrderService
{
    protected $order;
    protected $supplier;

    public function __construct(
        EloquentOrderRepository $order,
        SupplierInterface $supplier
    )
    {  
        $this->order    = $order;
        $this->supplier = $supplier;
    }  

    public function handle($data = [])
    {
        try {

        } catch (\ErrorException $e) {

        }       
    }

    protected function validate($data)
    {
        return validator($data, [
            'order_id' => 'required|string'
        ]);
    }
}
