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
        Schema::create('tb_transaction_items', function (Blueprint $table) {
            $table->id('trans_item_id');
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')
                ->references('transaction_id')
                ->on('tb_transaction');
            $table->unsignedBigInteger('prod_id');
            $table->foreign('prod_id')
                ->references('prod_id')
                ->on('tb_product');
            $table->integer('qty');
            $table->integer('unit_price');
            $table->integer('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_trans_item');
    }
};
