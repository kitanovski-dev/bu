<?php

namespace App\App\Domain\Suppiers;

use GuzzleHttp\ClientInterface;

abstract class AbstractSupplier
{
    protected $http;

    protected $apikey;

    protected $privateKey;

    public function __construct(ClientInterface $http, $apikey, $privateKey)
    {
        $this->http = $http;
        $this->apikey = $apikey;
        $this->privateKey = $privateKey;
    }
    
    abstract function createOrderUrl();
    abstract function createOrderData($customer, $product);
    
    abstract function cancelOrderUrl();
    abstract function cancelOrderData($data);

    public function createOrder($customer, $product)
    {
        $client = new \GuzzleHttp\Client();
        $url = $this->createOrderUrl();
        $body = $this->createOrderData($customer, $product);
        // return $body;
        $respond = $client->post($url, ['form_params' => $body]);

        return json_decode($respond->getContent(), true);
    }

    public function cancelOrderRequest($data)
    {
        $url = $this->canceleOrderUrl();
        $body = $this->cancelOrderData($data);

        $respond = $this->http->post($this->url, ['body' => $body]);

        return json_decode($respond)->getBody();
    }
}
