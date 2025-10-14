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
    ];

    protected $casts = [
        'ai_result' => 'array',
        'violations' => 'array',
        'suggestions' => 'array',
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
        return $this->compliance_score >= 70; // Misal passing score 70
    }
}
