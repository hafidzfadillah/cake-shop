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
        Schema::create('tb_product', function (Blueprint $table) {
            $table->id('prod_id');
            $table->string('prod_name');
            $table->text('prod_desc');
            $table->integer('prod_price');
            $table->integer('prod_price_promo');
            $table->integer('prod_stock');
            $table->text('prod_img_url');
            $table->unsignedBigInteger('prod_category_id');
            $table->foreign('prod_category_id')
                ->references('prod_category_id')
                ->on('tb_prod_category');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_product');
    }
};
