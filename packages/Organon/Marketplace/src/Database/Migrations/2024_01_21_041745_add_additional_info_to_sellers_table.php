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
        Schema::table('sellers', function (Blueprint $table) {
            $table->boolean('is_personal');
            $table->text('phone');
            $table->text('additional_phone');
            $table->text('landline');
            $table->text('additional_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn('is_personal');
            $table->dropColumn('phone');
            $table->dropColumn('additional_phone');
            $table->dropColumn('landline');
            $table->dropColumn('additional_email');
        });
    }
};
