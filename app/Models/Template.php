<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'faculty_id',
        'program_study_id',
        'rules',
        'description',
        'file_path',
        'is_active',
        'download_count',
    ];

    protected $casts = [
        'rules' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke Faculty
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Relasi ke Program Study
     */
    public function programStudy()
    {
        return $this->belongsTo(ProgramStudy::class);
    }

    /**
     * Relasi ke Document Checks
     */
    public function documentChecks()
    {
        return $this->hasMany(DocumentCheck::class);
    }

    /**
     * Increment download counter
     */
    public function incrementDownload()
    {
        $this->increment('download_count');
    }
}
