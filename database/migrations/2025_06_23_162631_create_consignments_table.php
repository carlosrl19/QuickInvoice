<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('person_name', 55);
            $table->string('person_dni', 13);
            $table->string('person_phone', 8);
            $table->string('person_address', 155);
            $table->string('consignment_code', 8);
            $table->date('consignment_date');
            $table->decimal('consignment_amount', 10, 2);
            $table->enum('consignment_status', ['completed']);
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('consignments');
    }
};
