<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $table = 'tb_transaction_items';
    protected $primaryKey = 'transaction_item_id';
    public $timestamps = false;

    protected $fillable = [
        'transaction_id',
        'prod_id',
        'qty',
        'unit_price',
        'subtotal',
        'created_at'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id', 'prod_id');
    }
}
