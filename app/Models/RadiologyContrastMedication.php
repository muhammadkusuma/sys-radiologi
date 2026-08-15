<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'assessment_id',
    'medication_name',
    'dose',
    'administration_route',
    'speed',
    'pressure',
    'administered_at',
    'reaction',
    'notes',
    'nurse_id',
    'nurse_initials',
])]
class RadiologyContrastMedication extends Model
{
    use HasFactory;

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(RadiologyContrastAssessment::class, 'assessment_id');
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }
}
