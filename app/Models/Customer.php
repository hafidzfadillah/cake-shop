<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tb_customer';
    protected $primaryKey = 'cust_id';
    public $timestamps = false;

    protected $fillable = [
        'cust_name',
        'cust_email',
        'cust_nohp',
        'user_id',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
