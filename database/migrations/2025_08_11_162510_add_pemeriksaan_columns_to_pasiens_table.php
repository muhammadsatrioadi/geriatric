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
            // Add pemeriksaan columns if they don't exist
            if (!Schema::hasColumn('pasiens', 'barthel_index')) {
                $table->integer('barthel_index')->nullable();
            }
            if (!Schema::hasColumn('pasiens', 'step_test')) {
                $table->integer('step_test')->nullable();
            }
            if (!Schema::hasColumn('pasiens', 'single_leg_open')) {
                $table->integer('single_leg_open')->nullable();
            }
            if (!Schema::hasColumn('pasiens', 'single_leg_closed')) {
                $table->integer('single_leg_closed')->nullable();
            }
            if (!Schema::hasColumn('pasiens', 'sit_to_stand')) {
                $table->float('sit_to_stand')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn(['barthel_index', 'step_test', 'single_leg_open', 'single_leg_closed', 'sit_to_stand']);
        });
    }
};
