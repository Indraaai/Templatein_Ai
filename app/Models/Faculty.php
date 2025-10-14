<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function programStudies(): HasMany
    {
        return $this->hasMany(ProgramStudy::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
