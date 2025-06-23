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
        Schema::create('work_formats', function (Blueprint $table) {
            $table->id();
            $table->dateTime('workformat_date');
            $table->string('client_name', 55);
            $table->string('client_phone', 8);
            $table->string('client_address', 255);
            $table->string('worker_name', 55);
            $table->string('receipt_number', 19)->nullable();
            $table->integer('workformat_type'); // 0: Orden de trabajo, 1: Estudio de campo, 2: Revisión equipo, 3: Recepción de equipo, 4: Entrega de equipo
            $table->string('workformat_description', 600);
            $table->text('client_signature');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_formats');
    }
};
