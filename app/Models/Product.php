<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_product';
    protected $primaryKey = 'prod_id';
    public $timestamps = false;

    protected $fillable = [
        'prod_name', 'prod_desc', 'prod_price', 'prod_price_promo',
        'prod_stock', 'prod_img_url',  'prod_category_id',
        'created_at', 'deleted_at', 'cloudinary_public_id',
    ];

   public function category() {
       return $this->belongsTo(ProductCategory::class, 'prod_category_id');
   }
}
