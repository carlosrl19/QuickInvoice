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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_name', 55);
            $table->string('client_code', 9);
            $table->string('client_document', 14);
            $table->string('client_type', 8); // Natural, Jurídico
            $table->string('client_phone1', 8);
            $table->string('client_phone2', 8)->nullable();
            $table->date('client_birthdate')->nullable();
            $table->string('client_phone_home', 8)->nullable();
            $table->string('client_actual_job', 55)->nullable();
            $table->string('client_phone_work', 8)->nullable();
            $table->integer('client_job_length')->nullable();
            $table->string('client_last_job', 55)->nullable();
            $table->boolean('client_own_business')->nullable(); // 0: No, 1: Sí
            $table->string('client_email')->nullable();
            $table->boolean('client_exonerated')->default(0);  // 0: Cliente sin exonerado, 1: Cliente exonerado
            $table->boolean('client_status')->default(1); // 0: Cliente inactivo, 1: Cliente activo
            $table->string('client_address', 155)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
