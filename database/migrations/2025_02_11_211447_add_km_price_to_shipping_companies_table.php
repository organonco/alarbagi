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
        Schema::table('shipping_companies', function (Blueprint $table) {
            $table->integer('km_price')->default(0);
            $table->dropColumn('per_order_price');
            $table->dropColumn('per_product_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            $table->dropColumn('km_price');
            $table->integer('per_order_price')->default(0);
            $table->integer('per_product_price')->default(0);
        });
    }
};
