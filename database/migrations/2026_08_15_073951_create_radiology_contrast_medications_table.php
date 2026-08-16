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
                ->cascadeOnDelete()
                ->comment('ID relasi ke tabel radiology_contrast_assessments');

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

            $table->string('medication_name')->comment('Nama obat kontras/medikasi yang diberikan');

            $table->string('dose')
                ->nullable()
                ->comment('Dosis obat kontras/medikasi');

            $table->string('administration_route')
                ->nullable()
                ->comment('Rute pemberian obat (cth: IV, Oral, dll)');

            $table->string('speed')
                ->nullable()
                ->comment('Kecepatan pemberian obat');

            $table->string('pressure')
                ->nullable()
                ->comment('Tekanan pemberian obat');

            $table->time('administered_at')
                ->nullable()
                ->comment('Waktu/jam pemberian obat');

            $table->text('reaction')
                ->nullable()
                ->comment('Reaksi setelah pemberian obat');

            $table->text('notes')
                ->nullable()
                ->comment('Catatan/keterangan tambahan');

            /*
            |--------------------------------------------------------------------------
            | PERAWAT
            |--------------------------------------------------------------------------
            */

            $table->foreignId('nurse_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('ID perawat yang memberikan medikasi (relasi ke users)');

            $table->string('nurse_initials')
                ->nullable()
                ->comment('Inisial/paraf perawat yang memberikan medikasi');

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
