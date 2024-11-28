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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->integer('price');
            $table->string('label');
            $table->timestamps();
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('variant_id')->nullable();
        });
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('variant_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('variant_id');
        });
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('variant_id');
        });
        Schema::dropIfExists('variants');
    }
};
