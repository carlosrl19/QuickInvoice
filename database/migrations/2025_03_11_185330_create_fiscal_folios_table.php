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
        Schema::create('fiscal_folios', function (Blueprint $table) {
            $table->id();
            $table->string('folio_authorized_range_start', 19);
            $table->string('folio_authorized_range_end', 19);
            $table->date('folio_authorized_emission_date');
            $table->integer('folio_total_invoices');
            $table->integer('folio_total_invoices_available');
            $table->boolean('folio_validation_status'); // 0: Vencido, 1: Válido
            $table->boolean('folio_status'); // 0: Sin usar, 1: En uso
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiscal_folios');
    }
};
