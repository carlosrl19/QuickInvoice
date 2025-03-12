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

            $table->decimal('loan_payment_amount', 10,2);
            $table->string('loan_payment_doc_number', 20);
            $table->decimal('loan_old_debt', 10,2);
            $table->decimal('loan_new_debt', 10,2);
            $table->dateTime('loan_payment_date');
            $table->string('loan_payment_comment', 255)->nullable();
            $table->string('loan_payment_img', 600)->nullable();
            $table->integer('loan_payment_type')->default(0); // 0: Pago de cuota, 1: Abono, 2: Finalización
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
