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
        $this->supplier = $supplier;
    }  

    public function handle($data = [])
    {
        /** Validate data ================================================= */
        // if (($validator = $this->validate($data))->fails()) {
        //     return new ValidationPayload($validator->getData());
        // }
         //  VALIDATOR WILL BE IMPROVED
        /** =============================================================== */

        try {

            /** Write in order table ======================================= */
            $order = $this->order->create($data);
            /** ============================================================ */

            
            /** Write in customer table ==================================== */
            $customerData = $data->customers;
            $customerData['order_id'] = $order->id;

            $customer  = $this->customer->create($customerData);
            /** ============================================================ */


            /** Write in status table - PENDING============================= */
            $status  = $this->status->create($order->id);
            /** ============================================================ */

        
            /** Write in product table ===================================== */
            $productsData = $data->products;
            $productsData['order_id'] = $order->id;

            $products = $this->product->create($productsData);
            /** ============================================================ */

        
            /** Create an order to Supplier ================================ */
            $createOrder = $this->createOrder($customer, $products);
            /** ============================================================ */
            
            return $createOrder; 

            /** instead of this return we will use class SuccessPayload 
             *  (namespace App\App\Domain\Payloads);
             * 
             * you can find an example in Src\Domain\Services\Auth\RegisterUserService -
             * that will be similar
             */ 

        } catch (\Exception $e) {
            // In this section I will integrate handlers for Errors
        }
        
    }

    protected function createOrder($customer, $products)
    {
        foreach ($products as $product) {
            $ordered = $this->supplier->createOrder($customer, $product);
        }
        
        return $ordered;
    }

    protected function cancelOrder($resId)
    {
        $canceled = $this->supplier->cancelOrder($resId);
        
        return $canceled;
    }

    protected function validate($data)
    {
        return validator($data, [
            'orderNumber'                       => 'required|string',
            'customers'                         => 'required|array',
            'products.*'                        => 'required|array',
            'products.*.type'                   => 'required|string',
            'products.*.data'                   => 'required|array',
            'products.*.data.ratePlanCode'      => 'required|string',
            'products.*.data.accommodationCode' => 'required|string',
            'products.*.data.arrivalDate'       => 'required|date|before:products.*.data.departureDate',
            'products.*.data.departureDate'     => 'required|date|after:products.*.data.arrivalDate',
            'products.*.data.landlordCode'      => 'required',
        ]);
    }

}
