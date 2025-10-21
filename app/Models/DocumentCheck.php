<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'original_filename',
        'file_path',
        'file_type',
        'file_size',
        'ai_result',
        'violations',
        'suggestions',
        'compliance_score',
        'check_status',
        'corrected_file_path',
        'corrected_filename',
        'ai_feedback',
        'ai_score',
        'ai_checked_at',
        'approval_status',
        'checked_by',
        'checked_at',
        'admin_notes',
    ];

    protected $casts = [
        'ai_result' => 'array',
        'violations' => 'array',
        'suggestions' => 'array',
        'ai_checked_at' => 'datetime',
        'checked_at' => 'datetime',
    ];

    /**
     * Relasi ke User (Mahasiswa)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Template
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Relasi ke Admin/Staff yang mengecek
     */
    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    /**
     * Check if AI processing is completed
     */
    public function isCompleted()
    {
        return $this->check_status === 'completed';
    }

    /**
     * Check if document passed
     */
    public function isPassed()
    {
        return $this->ai_score >= 75; // Passing score 75
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute()
    {
        return match ($this->approval_status) {
            'pending' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
            'approved' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>',
            'rejected' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>',
            'need_revision' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Need Revision</span>',
            default => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Unknown</span>',
        };
    }

    /**
     * Check if has corrected file
     */
    public function hasCorrectedFile()
    {
        return !empty($this->corrected_file_path);
    }
}
