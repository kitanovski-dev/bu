<?php

namespace App\App\Domain\Suppiers\OpenGDS;

use GuzzleHttp\Client;
use App\App\Domain\Suppiers\AbstractSupplier;
use App\App\Domain\Suppiers\SupplierInterface;
use App\Src\Domain\Repositories\Eloquent\EloquentSupplierOrderRepository;
use App\Src\Domain\Repositories\Eloquent\EloquentSupplierOrderLogRepository;
use App\Src\Domain\Repositories\Eloquent\EloquentProductSupplierOrderRepository;

class OpenGds implements SupplierInterface
{
    protected $supplierOrder;
    protected $supplierOrderLog;
    protected $productSupplierOrder;

    public function __construct(
        Client $http, 
        EloquentSupplierOrderRepository $supplierOrder,
        EloquentSupplierOrderLogRepository $supplierOrderLog,
        EloquentProductSupplierOrderRepository $productSupplierOrder
    )
    {
        $this->supplierOrderLog = $supplierOrderLog;
        $this->productSupplierOrder = $productSupplierOrder;
        $this->supplierOrder = $supplierOrder;
        $this->http = $http;
    }

    public function createOrder($customer, $product)
    {
        $productId = $product['product_id'];
        $url       = $this->createOrderUrl();
        $body      = $this->createOrderData($customer, $product);

        if($body) {
            $supplierOrderData = [
                'request_type'     => 'create',
                'service_provider' => 'opengds',
            ];

            $supplierOrder    = $this->supplierOrder->create($supplierOrderData);
            
            $productSupplierData = [
                'product_id'        => $productId,
                'supplier_order_id' => $supplierOrder['id'],
            ];
            
            $productSuplier = $this->productSupplierOrder->create($productSupplierData);
            

            $supplierOrderDataLog = [
                'supplier_order_id' => $supplierOrder['id'],
                'request'           => json_encode($body),
                'status'            => false,
            ];
            
            $supplierOrderLog = $this->supplierOrderLog->create($supplierOrderDataLog);
            
            
            $respond = $this->http->post($url, ['form_params' => $body]);
            
            
            $resId = [
                'reservation_id'   =>  json_decode($respond->getBody())->res_id
            ];

            if($resId) {
                $supplierOrderDataLog = [
                    'supplier_order_id' => $supplierOrder['id'],
                    'response'          => json_encode(json_decode($respond->getBody())),
                    'status'            => true,
                ];
                
                $this->supplierOrder->update($supplierOrder['id'], $resId);
                
                $this->supplierOrderLog->update($supplierOrderLog['id'], $supplierOrderDataLog);
            }

            /**
             * The respond will be integrated once the previous code is approved
             */
        }
        
    }

    public function cancelOrder($data)
    {
        $url  = $this->cancelOrderUrl();
        $body = $this->cancelOrderData($data);

        if($body) {
            $respond = $this->http->post($url, ['form_params' => $body]);

            return json_decode($respond->getBody());
        }
    }   

    
    public function createOrderUrl()
    {
        $url = "https://api.opengds.com/core/v1/acc-reservation/create?";

        return $url . http_build_query([
            'apikey'    =>  env('OPENGDS_APIKEY'),
            'privkey'   =>  env('OPENGDS_PRIVATEKEY')
        ]);
    }

    public function createOrderData($customer, $product)
    {
        // return $product;
        $product = $this->formatProducts($product);

        if($product) {
            $customer = [
                'first_name' => $customer['firstName'],
                'last_name'  => $customer['LastName'],
                'phone'      => $customer['phone'],
                'email'      => $customer['email'],
            ];
            
            return array_merge($customer, $product);
        }
    }

    public function cancelOrderUrl()
    {
        $url = "https://api.opengds.com/core/v1/acc-reservation/cancel?";

        return $url . http_build_query([
            'apikey'    =>  env('OPENGDS_APIKEY'),
            'privkey'   =>  env('OPENGDS_PRIVATEKEY')
        ]);
    }

    public function cancelOrderData($resId)
    {
        $body = [
            'res_id'    =>  $resId
        ];

        return $body;
    }

    protected function formatProducts($products) 
    {
        if($products['supplier'] == 'opengds') {
            unset($products['supplier']);
            $productReq['rate_id']   = $products['ratePlanCode'];
            $productReq['accom_id']  = $products['accommodationCode'];
            $productReq['arrival']   = $products['arrivalDate'];
            $productReq['depart']    = $products['departureDate'];
            $productReq['occupancy'] = 4;
            
            return $productReq;
        } 

        return false;
    }
}
