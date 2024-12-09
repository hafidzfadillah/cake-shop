<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tb_transaction', function (Blueprint $table) {
            $table->string('payment_method')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tb_transaction', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('created_at');
        });
    }
};
