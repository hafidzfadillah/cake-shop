<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'tb_transaction';
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;

    protected $fillable = [
        'cust_id',
        'trans_date',
        'ship_address',
        'payment_method',
        'rp_total',
        'transaction_status',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'trans_date' => 'datetime'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'cust_id');
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'transaction_id');
    }
}
