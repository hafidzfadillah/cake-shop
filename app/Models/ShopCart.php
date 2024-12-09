<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCart extends Model
{
    protected $table = 'tb_shopcart';
    protected $primaryKey = 'shop_cart_id';
    public $timestamps = false;

    protected $fillable = [
        'cust_id', 'prod_id', 'item_qty', 'created_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id', 'prod_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'cust_id');
    }
}
