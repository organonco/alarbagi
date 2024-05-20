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
        Schema::dropIfExists('warehouse_warehouse_admin');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('warehouse_warehouse_admin', function (Blueprint $table) {
            $table->id();
            $table->foreignId("warehouse_id");
            $table->foreignId("warehouse_admin_id");
        });
    }
};
