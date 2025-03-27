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
            $table->unsignedBigInteger('folio_id');
            $table->foreign('folio_id')->references('id')->on('fiscal_folios')->onDelete('cascade');
            
            $table->enum('sale_type',['E','G', 'ET']); // E: Exonerado, G: Gravado, ET: Exento
            $table->string('exempt_purchase_order_correlative',12)->nullable();
            $table->string('exonerated_certificate',11)->nullable();
            $table->string('folio_invoice_number',19);
            $table->decimal('sale_total_amount', 10, 2);
            $table->decimal('sale_payment_received', 10, 2);
            $table->decimal('sale_payment_change', 10, 2);
            $table->decimal('sale_discount', 10, 2);
            $table->boolean('sale_exempt_tax'); // 0: Con ISV, 1: Exento de ISV 
            $table->decimal('sale_tax', 10, 2);
            $table->decimal('sale_isv_amount', 10, 2);
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
