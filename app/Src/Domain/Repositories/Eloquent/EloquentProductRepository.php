<?php

namespace App\Src\Domain\Repositories\Eloquent;

use App\Src\Domain\Models\Product;
use App\Src\Domain\Repositories\AbstractRepository;

class EloquentProductRepository extends AbstractRepository
{
    public function entity()
    {
        return Product::class;
    }

    public function create($data)
    {
        $allProducts = [];

        $orderId = $data['order_id'];
        unset($data['order_id']);

        foreach ($data as $product) {
            $product1 = [
                'order_id' => $orderId,
                'type'     => $product['type'],
                'data'     => json_encode($product['data']),
            ];
            
            $allProducts[] = array($product['data']);
            $this->entity->create($product1);
        }

        return $allProducts;
    }
}
