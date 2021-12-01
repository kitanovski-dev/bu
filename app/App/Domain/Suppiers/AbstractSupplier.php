<?php

namespace App\App\Domain\Suppiers;

use App\Src\Domain\Repositories\Eloquent\EloquentSupplierOrderRepository;

abstract class AbstractSupplier
{
    protected $http;

    protected $apikey;

    protected $privateKey;
    
    protected $supplierOrder;

    public function __construct($apikey, $privateKey, EloquentSupplierOrderRepository $supplierOrder)
    {
        $this->apikey        = $apikey;
        $this->privateKey    = $privateKey;
        $this->supplierOrder = $supplierOrder;
    }
    
    abstract function createOrderUrl();

    abstract function createOrderData($customer, $product);
    
    abstract function cancelOrderUrl();
    
    abstract function cancelOrderData($data);

    
    public function createOrder($customer, $product)
    {
        $url  = $this->createOrderUrl();
        $body = $this->createOrderData($customer, $product);
        return $body;
        
        $respond = $this->http->post($url, ['form_params' => $body]);

        return json_decode($respond->getBody());
    }

    public function cancelOrder($data)
    {
        $url  = $this->cancelOrderUrl();
        $body = $this->cancelOrderData($data);

        $respond = $this->http->post($url, ['form_params' => $body]);

        return json_decode($respond->getBody());
    }   
}
