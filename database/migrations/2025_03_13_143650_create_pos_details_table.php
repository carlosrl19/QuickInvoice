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
        Schema::create('pos_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->unsignedBigInteger('sale_id');
            $table->foreign('sale_id')->references('id')->on('pos')->onDelete('cascade');
            $table->integer('sale_quantity');
            $table->decimal('sale_price',10,2);
            $table->decimal('sale_subtotal', 10, 2);
            $table->string('sale_details', 155)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_details');
    }
};
