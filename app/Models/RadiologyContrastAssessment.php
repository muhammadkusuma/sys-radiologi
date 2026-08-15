<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'patient_id',
    'procedure_date',
    'procedure_time',
    'referring_doctor_id',
    'radiology_nurse_id',
    'diagnosis',
    'examination_type',
    'general_condition',
    'consciousness_level',
    'egfr',
    'last_meal_time',
    'body_weight',
    'blood_pressure',
    'pulse',
    'temperature',
    'respiratory_rate',
    'oxygen_saturation',
    'pre_procedure_complaint',
    'has_allergy_history',
    'allergy_description',
    'contrast_batch',
    'contrast_concentration',
    'contrast_dose_ml',
    'contrast_double_check',
    'allergy_test',
    'allergy_test_result',
    'during_complaint',
    'allergy_sign_during',
    'itching_during',
    'nausea_during',
    'dizziness_during',
    'shortness_of_breath_during',
    'swollen_eyes_during',
    'swelling_during',
    'pain_during',
    'redness_during',
    'extravasation_sign_during',
    'iv_insertion_time',
    'region',
    'iv_cath_size',
    'post_procedure_complaint',
    'allergy_sign_after',
    'itching_after',
    'nausea_after',
    'dizziness_after',
    'shortness_of_breath_after',
    'swollen_eyes_after',
    'bentol_after',
    'swelling_after',
    'pain_after',
    'redness_after',
    'extravasation_sign_after',
    'post_blood_pressure',
    'post_pulse',
    'post_temperature',
    'post_respiratory_rate',
    'post_oxygen_saturation',
    'iv_removal_time',
    'medical_history',
    'created_by',
    'updated_by',
    'radiology_doctor_id',
    'doctor_signature',
    'nurse_signature',
    'signed_at',
])]
class RadiologyContrastAssessment extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'procedure_date' => 'date',
            'egfr' => 'decimal:2',
            'body_weight' => 'decimal:2',
            'temperature' => 'decimal:1',
            'oxygen_saturation' => 'decimal:2',
            'has_allergy_history' => 'boolean',
            'contrast_dose_ml' => 'decimal:2',
            'contrast_double_check' => 'boolean',
            'allergy_test' => 'boolean',
            'itching_during' => 'boolean',
            'nausea_during' => 'boolean',
            'dizziness_during' => 'boolean',
            'shortness_of_breath_during' => 'boolean',
            'swollen_eyes_during' => 'boolean',
            'swelling_during' => 'boolean',
            'pain_during' => 'boolean',
            'redness_during' => 'boolean',
            'itching_after' => 'boolean',
            'nausea_after' => 'boolean',
            'dizziness_after' => 'boolean',
            'shortness_of_breath_after' => 'boolean',
            'swollen_eyes_after' => 'boolean',
            'bentol_after' => 'boolean',
            'swelling_after' => 'boolean',
            'pain_after' => 'boolean',
            'redness_after' => 'boolean',
            'post_temperature' => 'decimal:1',
            'post_oxygen_saturation' => 'decimal:2',
            'medical_history' => 'array',
            'signed_at' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function referringDoctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referring_doctor_id');
    }

    public function radiologyNurse(): BelongsTo
    {
        return $this->belongsTo(User::class, 'radiology_nurse_id');
    }

    public function radiologyDoctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'radiology_doctor_id');
    }

    public function medications(): HasMany
    {
        return $this->hasMany(RadiologyContrastMedication::class, 'assessment_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
