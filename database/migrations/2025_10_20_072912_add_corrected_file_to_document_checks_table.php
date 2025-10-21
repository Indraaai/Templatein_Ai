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
        Schema::table('document_checks', function (Blueprint $table) {
            // File hasil koreksi AI
            $table->string('corrected_file_path')->nullable()->after('file_path');
            $table->string('corrected_filename')->nullable()->after('corrected_file_path');

            // Metadata AI analysis
            $table->text('ai_feedback')->nullable()->after('suggestions');
            $table->integer('ai_score')->nullable()->after('compliance_score');
            $table->timestamp('ai_checked_at')->nullable()->after('check_status');

            // Status approval (untuk admin review manual jika perlu)
            $table->enum('approval_status', ['pending', 'approved', 'rejected', 'need_revision'])->default('pending')->after('check_status');
            $table->foreignId('checked_by')->nullable()->constrained('users')->onDelete('set null')->after('approval_status');
            $table->timestamp('checked_at')->nullable()->after('checked_by');
            $table->text('admin_notes')->nullable()->after('checked_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_checks', function (Blueprint $table) {
            $table->dropColumn([
                'corrected_file_path',
                'corrected_filename',
                'ai_feedback',
                'ai_score',
                'ai_checked_at',
                'approval_status',
                'checked_by',
                'checked_at',
                'admin_notes',
            ]);
        });
    }
};
