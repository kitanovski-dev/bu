<?php

namespace App\Src\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'supplier_order';

    public function productSupplierOrder() {
        return $this->hasOne(ProductSupplierOrder::class);
    }

    public function supplierOrderLog() {
        return $this->hasOne(SupplierOrderLog::class);
    }

}
