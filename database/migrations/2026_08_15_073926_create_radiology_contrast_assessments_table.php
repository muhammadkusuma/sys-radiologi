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
                ->nullOnDelete()
                ->comment('ID pasien yang bersangkutan (relasi ke patients)');

            $table->date('procedure_date')
                ->nullable()
                ->comment('Tanggal pelaksanaan tindakan radiologi kontras');

            $table->time('procedure_time')
                ->nullable()
                ->comment('Waktu/jam tindakan radiologi kontras');

            $table->foreignId('referring_doctor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('ID dokter pengirim/perujuk (relasi ke users)');

            $table->foreignId('radiology_nurse_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('ID perawat radiologi yang mendokumentasikan (relasi ke users)');

            $table->text('diagnosis')
                ->nullable()
                ->comment('Diagnosis klinis pasien');

            $table->string('examination_type')
                ->nullable()
                ->comment('Jenis pemeriksaan radiologi kontras');

            /*
            |--------------------------------------------------------------------------
            | SEBELUM TINDAKAN
            |--------------------------------------------------------------------------
            */

            $table->string('general_condition')
                ->nullable()
                ->comment('Keadaan umum pasien sebelum tindakan');

            $table->string('consciousness_level')
                ->nullable()
                ->comment('Tingkat kesadaran pasien sebelum tindakan');

            $table->decimal('egfr', 8, 2)
                ->nullable()
                ->comment('Nilai eGFR (Estimated Glomerular Filtration Rate) pasien');

            $table->time('last_meal_time')
                ->nullable()
                ->comment('Waktu makan terakhir pasien sebelum tindakan');

            $table->decimal('body_weight', 6, 2)
                ->nullable()
                ->comment('Berat badan pasien (Kg)');

            $table->string('blood_pressure')
                ->nullable()
                ->comment('Tekanan darah pasien sebelum tindakan (mmHg)');

            $table->unsignedSmallInteger('pulse')
                ->nullable()
                ->comment('Nadi pasien sebelum tindakan (x/menit)');

            $table->decimal('temperature', 4, 1)
                ->nullable()
                ->comment('Suhu tubuh pasien sebelum tindakan (°C)');

            $table->unsignedSmallInteger('respiratory_rate')
                ->nullable()
                ->comment('Frekuensi pernafasan pasien sebelum tindakan (x/menit)');

            $table->decimal('oxygen_saturation', 5, 2)
                ->nullable()
                ->comment('Saturasi oksigen pasien sebelum tindakan (%)');

            $table->text('pre_procedure_complaint')
                ->nullable()
                ->comment('Keluhan pasien sebelum tindakan');

            /*
            |--------------------------------------------------------------------------
            | RIWAYAT ALERGI
            |--------------------------------------------------------------------------
            */

            $table->boolean('has_allergy_history')
                ->nullable()
                ->comment('Status memiliki riwayat alergi (0 = Tidak, 1 = Ada)');

            $table->text('allergy_description')
                ->nullable()
                ->comment('Keterangan deskripsi riwayat alergi pasien jika ada');

            /*
            |--------------------------------------------------------------------------
            | OBAT MEDIA KONTRAS
            |--------------------------------------------------------------------------
            */

            $table->string('contrast_batch')
                ->nullable()
                ->comment('Nomor batch media kontras yang digunakan');

            $table->string('contrast_concentration')
                ->nullable()
                ->comment('Konsentrasi media kontras');

            $table->decimal('contrast_dose_ml', 8, 2)
                ->nullable()
                ->comment('Dosis media kontras yang disuntikkan (ml)');

            $table->boolean('contrast_double_check')
                ->nullable()
                ->comment('Status pelaksanaan dobel cek obat kontras (0 = Tidak, 1 = Ya)');

            $table->boolean('allergy_test')
                ->nullable()
                ->comment('Status pelaksanaan test alergi kontras (0 = Tidak, 1 = Ya)');

            $table->enum('allergy_test_result', [
                'tidak_alergi',
                'alergi',
            ])->nullable()
                ->comment('Hasil tes alergi: tidak_alergi atau alergi');

            /*
            |--------------------------------------------------------------------------
            | SAAT TINDAKAN
            |--------------------------------------------------------------------------
            */

            $table->text('during_complaint')
                ->nullable()
                ->comment('Keluhan pasien saat tindakan berlangsung');

            $table->string('allergy_sign_during')
                ->nullable()
                ->comment('Tanda-tanda alergi yang muncul saat tindakan');

            $table->boolean('itching_during')
                ->nullable()
                ->comment('Adanya gatal-gatal saat tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('nausea_during')
                ->nullable()
                ->comment('Adanya mual saat tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('dizziness_during')
                ->nullable()
                ->comment('Adanya pusing saat tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('shortness_of_breath_during')
                ->nullable()
                ->comment('Adanya sesak nafas saat tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('swollen_eyes_during')
                ->nullable()
                ->comment('Adanya mata bengkak saat tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('swelling_during')
                ->nullable()
                ->comment('Adanya bengkak saat tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('pain_during')
                ->nullable()
                ->comment('Adanya nyeri saat tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('redness_during')
                ->nullable()
                ->comment('Adanya kemerahan saat tindakan (0 = Tidak, 1 = Ya)');

            $table->text('extravasation_sign_during')
                ->nullable()
                ->comment('Tanda-tanda ekstravasasi saat tindakan');

            $table->time('iv_insertion_time')
                ->nullable()
                ->comment('Waktu/jam pemasangan infus');

            $table->string('region')
                ->nullable()
                ->comment('Lokasi/regio pemasangan infus');

            $table->string('iv_cath_size')
                ->nullable()
                ->comment('Ukuran IV catheter (abocath) yang digunakan');

            /*
            |--------------------------------------------------------------------------
            | SETELAH TINDAKAN
            |--------------------------------------------------------------------------
            */

            $table->text('post_procedure_complaint')
                ->nullable()
                ->comment('Keluhan pasien setelah tindakan selesai');

            $table->string('allergy_sign_after')
                ->nullable()
                ->comment('Tanda-tanda alergi yang muncul setelah tindakan');

            $table->boolean('itching_after')
                ->nullable()
                ->comment('Adanya gatal-gatal setelah tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('nausea_after')
                ->nullable()
                ->comment('Adanya mual setelah tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('dizziness_after')
                ->nullable()
                ->comment('Adanya pusing setelah tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('shortness_of_breath_after')
                ->nullable()
                ->comment('Adanya sesak nafas setelah tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('swollen_eyes_after')
                ->nullable()
                ->comment('Adanya mata bengkak setelah tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('bentol_after')
                ->nullable()
                ->comment('Adanya bentol-bentol setelah tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('swelling_after')
                ->nullable()
                ->comment('Adanya bengkak setelah tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('pain_after')
                ->nullable()
                ->comment('Adanya nyeri setelah tindakan (0 = Tidak, 1 = Ya)');

            $table->boolean('redness_after')
                ->nullable()
                ->comment('Adanya kemerahan setelah tindakan (0 = Tidak, 1 = Ya)');

            $table->text('extravasation_sign_after')
                ->nullable()
                ->comment('Tanda-tanda ekstravasasi setelah tindakan');

            $table->string('post_blood_pressure')
                ->nullable()
                ->comment('Tekanan darah pasien setelah tindakan (mmHg)');

            $table->unsignedSmallInteger('post_pulse')
                ->nullable()
                ->comment('Nadi pasien setelah tindakan (x/menit)');

            $table->decimal('post_temperature', 4, 1)
                ->nullable()
                ->comment('Suhu tubuh pasien setelah tindakan (°C)');

            $table->unsignedSmallInteger('post_respiratory_rate')
                ->nullable()
                ->comment('Frekuensi pernafasan pasien setelah tindakan (x/menit)');

            $table->decimal('post_oxygen_saturation', 5, 2)
                ->nullable()
                ->comment('Saturasi oksigen pasien setelah tindakan (%)');

            $table->time('iv_removal_time')
                ->nullable()
                ->comment('Waktu/jam pelepasan infus');

            /*
            |--------------------------------------------------------------------------
            | RIWAYAT PENYAKIT
            |--------------------------------------------------------------------------
            */

            $table->json('medical_history')
                ->nullable()
                ->comment('Daftar riwayat penyakit penyerta pasien dalam format JSON (cth: Diabetes, Kemo)');

            /*
            |--------------------------------------------------------------------------
            | AUDIT
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('ID pembuat dokumen asesmen (relasi ke users)');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('ID pengubah terakhir dokumen asesmen (relasi ke users)');

            $table->foreignId('radiology_doctor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('ID dokter radiologi penanggung jawab (relasi ke users)');

            $table->longText('doctor_signature')
                ->nullable()
                ->comment('Tanda tangan digital dokter radiologi (base64)');

            $table->longText('nurse_signature')
                ->nullable()
                ->comment('Tanda tangan digital perawat radiologi (base64)');

            $table->timestamp('signed_at')
                ->nullable()
                ->comment('Waktu penandatanganan dokumen');

            $table->timestamps();
            $table->softDeletes()->comment('Waktu penghapusan dokumen soft delete');

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
