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
        Schema::table('videos', function (Blueprint $table) {
            // Add new columns for enhanced categorization
            $table->enum('category_type', ['overall', 'per_test'])->after('klasifikasi')->default('overall');
            $table->enum('test_type', ['barthel', 'two_minute', 'single_leg', 'five_stand'])->nullable()->after('category_type');
            $table->enum('level', ['normal', 'ringan', 'berat'])->after('test_type')->default('normal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['category_type', 'test_type', 'level']);
        });
    }
};
