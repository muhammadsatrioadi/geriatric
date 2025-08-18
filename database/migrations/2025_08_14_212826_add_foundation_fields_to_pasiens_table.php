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
            $table->unsignedBigInteger('foundation_id')->nullable()->after('id');
            $table->string('owned_by')->nullable()->after('foundation_id'); // 'admin' atau 'foundation'
            $table->boolean('public_visible')->default(false)->after('owned_by');
            
            $table->foreign('foundation_id')->references('id')->on('foundations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropForeign(['foundation_id']);
            $table->dropColumn(['foundation_id', 'owned_by', 'public_visible']);
        });
    }
};
