<?php

namespace App\App\Domain\Suppiers\OpenGDS;

use App\App\Domain\Suppiers\AbstractSupplier;
use App\App\Domain\Suppiers\SupplierInterface;
use App\Src\Domain\Repositories\Eloquent\EloquentSupplierOrderRepository;

class OpenGds extends AbstractSupplier implements SupplierInterface
{
    protected $supplierOrder;

    public function __construct(EloquentSupplierOrderRepository $supplierOrder)
    {
        $this->supplierOrder = $supplierOrder;
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
        // return $product[0][0]['ratePlanCode'];
        $body = [
            'rate_id'=> $product[0][0]['ratePlanCode'],
            'accom_id'=> $product[0][0]['accommodationCode'],
            'arrival'=> $product[0][0]['arrivalDate'],
            'depart'=> $product[0][0]['departureDate'],
            'occupancy'=> 4,
            'first_name'=> $customer['firstName'],
            'last_name'=> $customer['LastName'],
            // 'gender'=> $mainBookerGender,
            'phone'=> $customer['phone'],
            'email'=> $customer['email']
        ];

        return $body;
    }

    public function cancelOrderUrl()
    {

    }

    public function cancelOrderData($data)
    {
        
    }
}
