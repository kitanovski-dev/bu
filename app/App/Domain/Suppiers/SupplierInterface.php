<?php

namespace App\App\Domain\Suppiers;

interface SupplierInterface
{
    public function createOrder($customer, $product);
}
