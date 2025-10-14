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
        Schema::table('templates', function (Blueprint $table) {
            $table->text('description')->nullable()->after('type');
            $table->string('file_path')->nullable()->after('rules');
            $table->boolean('is_active')->default(true)->after('file_path');
            $table->integer('download_count')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn(['description', 'file_path', 'is_active', 'download_count']);
        });
    }
};
