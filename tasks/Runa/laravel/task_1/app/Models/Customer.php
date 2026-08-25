<?php

namespace App\Models;

use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<CustomerFactory> */
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}