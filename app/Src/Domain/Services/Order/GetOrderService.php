<?php

namespace App\Src\Domain\Services\Order;

class GetOrderService
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function handle($data = [])
    {
        // public function getOrderDetails($orderId,$requestType = "") {
        //     $query = Order::with(['product','product.customer'])
        //                 ->where('order_no',$orderId);
        //     if($requestType != "")
        //         $query->where('request_type',$requestType);
        //     $orders = $query->get();
        //     return $orders;
        // }
    }
}
