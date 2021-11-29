<?php

namespace App\Src\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'customer';

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
