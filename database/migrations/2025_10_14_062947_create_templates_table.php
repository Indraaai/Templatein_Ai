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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // Jenis template: 'skripsi', 'proposal', 'tugas_akhir', dll
            $table->text('description')->nullable();
            $table->foreignId('faculty_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('program_study_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('template_rules'); // Menyimpan aturan dalam format JSON
            $table->string('template_file')->nullable(); // Path to generated .docx file
            $table->boolean('is_active')->default(true);
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
