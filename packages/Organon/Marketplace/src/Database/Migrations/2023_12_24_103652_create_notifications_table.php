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
        Schema::drop('notifications');
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->boolean('read')->default(false);
            $table->foreignId('admin_id')->nullable();
            $table->string('route')->nullable();
            $table->json('route_params')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
