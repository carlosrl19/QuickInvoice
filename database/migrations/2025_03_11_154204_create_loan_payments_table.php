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
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('loan_id');
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');

            $table->decimal('loan_quote_payment_amount', 10,2);
            $table->string('loan_quote_payment_doc_number', 20);
            $table->decimal('loan_old_debt', 10,2);
            $table->decimal('loan_new_debt', 10,2);
            $table->decimal('loan_quote_arrears', 10,2);
            $table->date('loan_quote_payment_date');
            $table->string('loan_quote_payment_comment', 255)->nullable();
            $table->integer('loan_quote_payment_status')->default(0); // 0: Pendiente, 1: Pagado, 2: Atrasado
            
            $table->integer('loan_quote_payment_mode'); // 1: Efectivo, 2: Cheque, 3: Depósito, 4: Dólar, 5: Tarjeta
            $table->string('card_last_digits', 4)->nullable(); // Solo si se usa Tarjeta como loan_quote_payment_mode
            $table->string('card_auth_number', 12)->nullable(); // Solo si se usa Tarjeta como loan_quote_payment_mode
            $table->decimal('loan_quote_payment_received', 10,2);
            $table->decimal('loan_quote_payment_change', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};
