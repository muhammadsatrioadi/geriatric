<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the enum to include 'self_assessment'
        DB::statement("ALTER TABLE videos MODIFY COLUMN category_type ENUM('overall', 'per_test', 'self_assessment') DEFAULT 'overall'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE videos MODIFY COLUMN category_type ENUM('overall', 'per_test') DEFAULT 'overall'");
    }
};
