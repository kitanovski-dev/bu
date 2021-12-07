<?php

namespace App\Src\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSupplierOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'product_supplier_order';

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function supplierOrder() {
        return $this->belongsTo(SupplierOrder::class);
    }
}
