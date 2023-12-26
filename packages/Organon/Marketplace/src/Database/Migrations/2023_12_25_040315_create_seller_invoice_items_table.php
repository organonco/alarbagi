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
        Schema::create('seller_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->double('amount');
            $table->string('type');
            $table->string('comment')->nullable();
            $table->foreignId('seller_invoice_id');
            $table->foreignId('seller_order_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_invoice_items');
    }
};
