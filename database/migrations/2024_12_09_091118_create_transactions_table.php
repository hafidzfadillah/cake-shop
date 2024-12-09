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
        Schema::create('tb_transaction', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->unsignedBigInteger('cust_id');
            $table->foreign('cust_id')
                ->references('cust_id')
                ->on('tb_customer');
            $table->integer('rp_total');
            $table->timestamp('transaction_datetime')->useCurrent();
            $table->enum('transaction_status', ['pending', 'completed', 'cancelled']);
            $table->text('ship_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaction');
    }
};
