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
        Schema::create('consignment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consignment_id');
            $table->foreign('consignment_id')->references('id')->on('consignments')->onDelete('cascade'); // Cambiado de 'sales' a 'consignments'
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('quantity')->unsigned(); // Cambiado de 'product_quantity' a 'quantity' para consistencia
            $table->decimal('unit_price', 10, 2); // Agregado para registrar el precio histórico
            $table->decimal('total_price', 10, 2); // Agregado para calcular el total por producto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignment_details');
    }
};
