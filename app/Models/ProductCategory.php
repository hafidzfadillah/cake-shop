<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'tb_prod_category';
       protected $primaryKey = 'prod_category_id';
       public $timestamps = false;

       protected $fillable = [
           'prod_category_name',
           'created_at'
       ];

       public function products()
       {
           return $this->hasMany(Product::class, 'prod_category_id', 'prod_category_id');
       }
}
