<?php

namespace App\Src\Domain\Repositories\Eloquent;

use App\Src\Domain\Models\Customer;
use App\Src\Domain\Repositories\AbstractRepository;

class EloquentCustomerRepository extends AbstractRepository
{
    public function entity()
    {
        return Customer::class;
    }
    public function create($customers)
    {
        $orderId = $customers['order_id'];
        unset($customers['order_id']);
        
        foreach ($customers as $customer) {
            $customer['order_id']    = $orderId;
            $customer['first_name']  = $customer['firstName'];
            $customer['last_name']   = $customer['LastName'];
            $customer['birth_date']  = $customer['dateOfBirth'];
            
            if(array_key_exists('mainBooker', $customer)){
                $customer['main_booker'] = true;
                $mainBooker = $customer;
            } else {
                $customer['main_booker'] = false;
            }
            
            $this->entity->create($customer);
        }

        return $mainBooker;
    }
}