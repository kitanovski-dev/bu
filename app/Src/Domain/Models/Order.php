<?php

namespace App\Src\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'order';

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function status() {
        return $this->hasOne(OrderStatus::class);
    }

    public function customers() {
        return $this->hasMany(Customer::class);
    }


}
