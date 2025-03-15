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
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->decimal('sale_total_amount', 10, 2);
            $table->decimal('sale_payment', 10, 2);
            $table->decimal('sale_payment_change', 10, 2);
            $table->decimal('sale_discount', 10, 2);
            $table->decimal('sale_tax', 10, 2);
            $table->integer('sale_payment_type'); // 1: Efectivo, 2: Tarjeta, 3: Deposito
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos');
    }
};
