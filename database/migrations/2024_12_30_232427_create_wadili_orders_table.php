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
        Schema::create('wadili_orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('success');
            $table->string('message');
            $table->string('number');
            $table->integer('service_fees');
            $table->double('distance');
            $table->string('wadili_order_id');
            $table->string('payment_method');
            $table->foreignId('cart_id');
            $table->foreignId('order_id')->nullable();
            $table->integer('total');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wadili_orders');
    }
};
