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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->string('loan_code_number', 9); // Código de prestamo
            $table->string('loan_request_number', 9); // Código de solicitud
            $table->integer('loan_payment_type'); // 1: Diario, 2: Semanal, 3: Quincenal, 4: Mensual
            $table->decimal('loan_amount', 10,2);
            $table->decimal('loan_down_payment', 10,2); // Prima
            $table->decimal('loan_quote_value', 10,2); // loan_total / loan_quote_number
            $table->decimal('loan_amount_weekly_arrears', 10,2); // Monto diario por mora
            $table->decimal('loan_interest', 5,2);
            $table->decimal('loan_total', 10,2); // loan_amount + (loan_amount * loan_interest)
            $table->date('loan_start_date');
            $table->date('loan_end_date');
            $table->integer('loan_quote_number'); // Número de cuotas
            $table->integer('loan_status'); // 0: Solicitud 1: En proceso, 2: Finalizado/Pagado, 4: Anulado
            $table->integer('loan_request_status'); // 0: Solicitud en espera, 1: Solicitud aceptada, 2: Solicitud rechazada, 3: Anulado
            $table->string('loan_description', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
