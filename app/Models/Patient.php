<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'medical_record_number',
    'name',
    'gender',
    'date_of_birth',
    'phone',
    'address',
])]
class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function radiologyContrastAssessments(): HasMany
    {
        return $this->hasMany(RadiologyContrastAssessment::class, 'patient_id');
    }
}
