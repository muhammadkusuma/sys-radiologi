<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('radiology_contrast_assessments', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | IDENTITAS
            |--------------------------------------------------------------------------
            */

            $table->foreignId('patient_id')
                ->nullable()
                ->constrained('patients')
                ->nullOnDelete();

            $table->date('procedure_date')
                ->nullable();

            $table->time('procedure_time')
                ->nullable();

            $table->foreignId('referring_doctor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('radiology_nurse_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('diagnosis')
                ->nullable();

            $table->string('examination_type')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | SEBELUM TINDAKAN
            |--------------------------------------------------------------------------
            */

            $table->string('general_condition')
                ->nullable();

            $table->string('consciousness_level')
                ->nullable();

            $table->decimal('egfr', 8, 2)
                ->nullable();

            $table->time('last_meal_time')
                ->nullable();

            $table->decimal('body_weight', 6, 2)
                ->nullable();

            $table->string('blood_pressure')
                ->nullable();

            $table->unsignedSmallInteger('pulse')
                ->nullable();

            $table->decimal('temperature', 4, 1)
                ->nullable();

            $table->unsignedSmallInteger('respiratory_rate')
                ->nullable();

            $table->decimal('oxygen_saturation', 5, 2)
                ->nullable();

            $table->text('pre_procedure_complaint')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | RIWAYAT ALERGI
            |--------------------------------------------------------------------------
            */

            $table->boolean('has_allergy_history')
                ->nullable();

            $table->text('allergy_description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | OBAT MEDIA KONTRAS
            |--------------------------------------------------------------------------
            */

            $table->string('contrast_batch')
                ->nullable();

            $table->string('contrast_concentration')
                ->nullable();

            $table->decimal('contrast_dose_ml', 8, 2)
                ->nullable();

            $table->boolean('contrast_double_check')
                ->nullable();

            $table->boolean('allergy_test')
                ->nullable();

            $table->enum('allergy_test_result', [
                'tidak_alergi',
                'alergi',
            ])->nullable();

            /*
            |--------------------------------------------------------------------------
            | SAAT TINDAKAN
            |--------------------------------------------------------------------------
            */

            $table->text('during_complaint')
                ->nullable();

            $table->string('allergy_sign_during')
                ->nullable();

            $table->boolean('itching_during')
                ->nullable();

            $table->boolean('nausea_during')
                ->nullable();

            $table->boolean('dizziness_during')
                ->nullable();

            $table->boolean('shortness_of_breath_during')
                ->nullable();

            $table->boolean('swollen_eyes_during')
                ->nullable();

            $table->boolean('swelling_during')
                ->nullable();

            $table->boolean('pain_during')
                ->nullable();

            $table->boolean('redness_during')
                ->nullable();

            $table->text('extravasation_sign_during')
                ->nullable();

            $table->time('iv_insertion_time')
                ->nullable();

            $table->string('region')
                ->nullable();

            $table->string('iv_cath_size')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | SETELAH TINDAKAN
            |--------------------------------------------------------------------------
            */

            $table->text('post_procedure_complaint')
                ->nullable();

            $table->string('allergy_sign_after')
                ->nullable();

            $table->boolean('itching_after')
                ->nullable();

            $table->boolean('nausea_after')
                ->nullable();

            $table->boolean('dizziness_after')
                ->nullable();

            $table->boolean('shortness_of_breath_after')
                ->nullable();

            $table->boolean('swollen_eyes_after')
                ->nullable();

            $table->boolean('bentol_after')
                ->nullable();

            $table->boolean('swelling_after')
                ->nullable();

            $table->boolean('pain_after')
                ->nullable();

            $table->boolean('redness_after')
                ->nullable();

            $table->text('extravasation_sign_after')
                ->nullable();

            $table->string('post_blood_pressure')
                ->nullable();

            $table->unsignedSmallInteger('post_pulse')
                ->nullable();

            $table->decimal('post_temperature', 4, 1)
                ->nullable();

            $table->unsignedSmallInteger('post_respiratory_rate')
                ->nullable();

            $table->decimal('post_oxygen_saturation', 5, 2)
                ->nullable();

            $table->time('iv_removal_time')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | RIWAYAT PENYAKIT
            |--------------------------------------------------------------------------
            |
            | Berdasarkan HTML saat ini terdapat:
            | - Kemo/Radioterapi
            | - Diabetes
            |
            | Dibuat JSON agar mudah ditambah tanpa migration baru.
            |
            */

            $table->json('medical_history')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | AUDIT
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('radiology_doctor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->longText('doctor_signature')
                ->nullable();

            $table->longText('nurse_signature')
                ->nullable();

            $table->timestamp('signed_at')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index('procedure_date');
            $table->index('examination_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radiology_contrast_assessments');
    }
};
