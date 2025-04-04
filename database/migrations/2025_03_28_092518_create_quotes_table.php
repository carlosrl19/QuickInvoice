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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_code', 9);
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');

            $table->enum('quote_type', ['E', 'G', 'ET']); // E: Exonerado, G: Gravado, ET: Exento
            $table->decimal('quote_total_amount', 10, 2);
            $table->decimal('quote_discount', 10, 2);
            $table->boolean('quote_exempt_tax'); // 0: Con ISV, 1: Exento de ISV 
            $table->decimal('quote_tax', 10, 2);
            $table->decimal('quote_isv_amount', 10, 2);
            $table->date('quote_expiration_date');
            $table->integer('quote_status'); // 0: En proceso, 1: Aceptada, 2: Rechazada, 3: Sin respuesta, 4: Vencida
            $table->string('quote_answer', 75)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
