<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_shopcart', function (Blueprint $table) {
            $table->id('shop_cart_id');
            $table->unsignedBigInteger('cust_id');
            $table->foreign('cust_id')
                ->references('cust_id')
                ->on('tb_customer');
            $table->unsignedBigInteger('prod_id');
            $table->foreign('prod_id')
                ->references('prod_id')
                ->on('tb_product');
            $table->integer('item_qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_shopcart');
    }
};
