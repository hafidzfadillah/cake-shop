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
            // $table->id('cust_id'); // Primary key
            // $table->string('cust_name', 255);
            // $table->string('cust_email', 255)->unique();
            // $table->string('cust_password', 255);
            // $table->string('cust_nohp', 255);
            // $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_customer', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
