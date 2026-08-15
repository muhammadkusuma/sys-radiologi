<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('radiology_contrast_medications', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELASI ASESMEN
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assessment_id')
                ->constrained('radiology_contrast_assessments')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | CATATAN PEMBERIAN OBAT
            |--------------------------------------------------------------------------
            |
            | Sesuai kolom HTML:
            | Nama Obat
            | Dosis
            | Rute Pemberian
            | Kecepatan
            | Tekanan
            | Jam
            | Reaksi
            | Keterangan
            | Paraf Perawat
            |
            */

            $table->string('medication_name');

            $table->string('dose')
                ->nullable();

            $table->string('administration_route')
                ->nullable();

            $table->string('speed')
                ->nullable();

            $table->string('pressure')
                ->nullable();

            $table->time('administered_at')
                ->nullable();

            $table->text('reaction')
                ->nullable();

            $table->text('notes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | PERAWAT
            |--------------------------------------------------------------------------
            */

            $table->foreignId('nurse_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('nurse_initials')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index([
                'assessment_id',
                'administered_at',
            ], 'rad_contrast_meds_assessment_admin_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radiology_contrast_medications');
    }
};
