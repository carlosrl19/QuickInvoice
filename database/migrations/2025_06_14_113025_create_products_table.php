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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code', 10);
            $table->string('product_nomenclature', 20); // tabla

            $table->string('product_name', 55);
            $table->string('product_brand', 20);
            $table->string('product_model', 20)->nullable();
            $table->integer('product_status'); // 0: Malo, 1: Nuevo, 2: Seminuevo, 3: Usado

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->integer('product_stock');
            $table->decimal('product_price', 10, 2); // tabla

            $table->string('product_description', 600)->nullable();
            $table->string('product_status_description', 600); // tabla
            $table->string('product_image')->nullable();
            $table->string('product_reviewed_by',);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
