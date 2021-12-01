<?php

namespace App\App\Domain\Suppiers\OpenGDS;

use GuzzleHttp\Client;
use App\App\Domain\Suppiers\AbstractSupplier;
use App\App\Domain\Suppiers\SupplierInterface;
use App\Src\Domain\Repositories\Eloquent\EloquentSupplierOrderRepository;

class OpenGds implements SupplierInterface
{
    protected $supplierOrder;

    public function __construct(Client $http, EloquentSupplierOrderRepository $supplierOrder)
    {
        $this->supplierOrder = $supplierOrder;
        $this->http = $http;
    }

    public function createOrder($customer, $product)
    {
        $url  = $this->createOrderUrl();
        $body = $this->createOrderData($customer, $product);
        
        if($body) {
            $data = [
                'request_type'     => 'create',
                'service_provider' => 'opengds',
            ];
            
            $supplierOrder = $this->supplierOrder->create($data);
            
            $respond = $this->http->post($url, ['form_params' => $body]);
            
            $resId = [
                'reservation_id'   =>  json_decode($respond->getBody())->res_id
            ];

            $this->supplierOrder->update($supplierOrder['id'], $resId);
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
        $product = $this->formatProducts($product);
        // return $product;

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
