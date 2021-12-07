<?php

namespace App\Src\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrderLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'supplier_order_log';

    public function supplierOrder() {
        return $this->belongsTo(SupplierOrder::class);
    }
}
