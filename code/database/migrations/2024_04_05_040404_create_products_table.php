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
            $table->integer('code');
            $table->text('status');
            $table->timestampTz('imported_t');
            $table->timestamps();
            $table->text('url');
            $table->text('creator');
            $table->text('product_name');
            $table->text('quantity');
            $table->text('brands');
            $table->text('categories');
            $table->text('labels');
            $table->text('cities');
            $table->text('purchase_places');
            $table->text('stores');
            $table->longText('ingredients_text');
            $table->text('traces');
            $table->text('serving_size');
            $table->float('serving_quantity');
            $table->integer('nutriscore_score');
            $table->text('nutriscore_grade');
            $table->text('main_category');
            $table->longText('image_url');
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
