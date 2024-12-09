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
        Schema::create('tb_customer', function (Blueprint $table) {
            $table->id('cust_id');
            $table->string('cust_name');
            $table->string('cust_email');
            $table->string('cust_password')->nullable(false)->default(hash('sha256', ''));
            $table->string('cust_nohp');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_customer');
    }
};
