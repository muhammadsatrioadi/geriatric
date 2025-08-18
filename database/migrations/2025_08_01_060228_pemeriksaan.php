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
        Schema::table('pasiens', function (Blueprint $table) {
            $table->integer('barthel_index')->nullable();
            $table->integer('step_test')->nullable();
            // replace single_leg with separate open/closed fields
            $table->integer('single_leg_open')->nullable();
            $table->integer('single_leg_closed')->nullable();
            $table->float('sit_to_stand')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            // drop all pemeriksaan columns
            $table->dropColumn(['barthel_index', 'step_test', 'sit_to_stand', 'single_leg_open', 'single_leg_closed']);
        });
    }
};
