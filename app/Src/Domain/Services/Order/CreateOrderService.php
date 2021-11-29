<?php

namespace App\Src\Domain\Services\Order;

use App\App\Domain\Suppiers\SupplierInterface;
use App\Src\Domain\Repositories\Eloquent\EloquentCustomerRepository;
use App\Src\Domain\Repositories\Eloquent\EloquentOrderRepository;
use App\Src\Domain\Repositories\Eloquent\EloquentProductRepository;
use App\Src\Domain\Repositories\Eloquent\EloquentStatusRepository;

class CreateOrderService
{
    protected $order;
    protected $customer;
    protected $status;
    protected $product;
    protected $supplier;

    public function __construct(
        EloquentOrderRepository $order,
        EloquentCustomerRepository $customer,
        EloquentStatusRepository $status,
        EloquentProductRepository $product,
        SupplierInterface $supplier
    )
    {  
        $this->order    = $order;
        $this->customer = $customer;
        $this->status   = $status;
        $this->product  = $product;
        $this->supplier  = $supplier;
    }  

    public function handle($data = [])
    {
        /** Write in order table */
        $order = $this->order->create($data);

        
        /** Write in customer table */
        $customerData = $data->customers;
        $customerData['order_id'] = $order->id;

        $customer  = $this->customer->create($customerData);


        /** Write in status table - PENDING*/
        $status  = $this->status->create($order->id);


        /** Write in product table */
        $productsData = $data->products;
        $productsData['order_id'] = $order->id;

        $product = $this->product->create($productsData);
        
        // return $customer;

        $createOrder = $this->createOrder($customer, $product);
         
        return $createOrder;
        
    }

    protected function createOrder($customer, $product)
    {
        $ordered = $this->supplier->createOrder($customer, $product);
        
        return $ordered;
    }

}
