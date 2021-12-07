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
            $productData = [
                'order_id' => $orderId,
                'type'     => $product['type'],
                'supplier' => $product['data']['supplier'],
                'data'     => json_encode($product['data']),
            ];
            
            $products = $this->entity->create($productData);
            $product['data']['product_id'] = $products['id'];
            $allProducts[] = array($product['data']);
        }

        return array_column($allProducts, 0);
    }
}
