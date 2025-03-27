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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_company')->nullable();
            $table->string('system_icon')->nullable();
            $table->boolean('show_system_name')->default(1)->nullable();
            $table->string('company_name', 25)->nullable();
            $table->string('company_cai', 37)->nullable(); // 32 + 5 guiones
            $table->string('company_rtn', 14)->nullable();
            $table->string('company_phone', 9)->nullable(); // 8 + 1 guión
            $table->string('company_email', 50)->nullable();
            $table->string('company_address', 75)->nullable();
            $table->string('company_short_address', 35)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
