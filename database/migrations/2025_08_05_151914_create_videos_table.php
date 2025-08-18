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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file_path'); // Path ke file video di storage
            $table->string('file_name'); // Nama asli file
            $table->bigInteger('file_size'); // Ukuran file dalam byte
            $table->string('file_type'); // Tipe file (mp4, avi, dll)
            $table->enum('jenis', ['global', 'khusus']); // Global untuk superadmin, khusus untuk admin
            $table->enum('klasifikasi', ['Tinggi', 'Sedang', 'Rendah'])->nullable(); // Untuk video global
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Admin yang upload
            $table->foreignId('pasien_id')->nullable()->constrained('pasiens')->onDelete('cascade'); // Untuk video khusus
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
