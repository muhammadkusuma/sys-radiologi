<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_consents', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Pasien
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            
            // DOKTER PEMBERI INFORMASI (bisa nama atau ID dokter)
            $table->string('doctor')->nullable()->comment('Nama atau ID Dokter Pemberi Informasi');
            
            // PENERIMA INFORMASI
            $table->string('recipient_name')->nullable()->comment('Nama Penerima Informasi');
            
            // HUBUNGAN DENGAN PASIEN (Keluarga terdekat)
            $table->string('relationship')->nullable()->comment('Hubungan penerima informasi dengan pasien');
            $table->string('other_relationship')->nullable()->comment('Hubungan penerima informasi dengan pasien (Lainnya)');
            
            // DIAGNOSIS & TINDAKAN
            $table->text('diagnosis')->nullable()->comment('Diagnosis (WD & DD)');
            $table->text('planned_procedure')->nullable()->comment('Tindakan Kedokteran / Planned Procedure');
            
            // ALTERNATIF TINDAKAN
            $table->string('alternative_treatment')->nullable()->comment('Pilihan Alternatif Tindakan (none/yes)');
            $table->string('alternative_treatment_detail')->nullable()->comment('Detail Alternatif Tindakan');
            
            // DIAGNOSIS INISIAL (Ceklis paraf)
            $table->json('diagnosis_initial')->nullable()->comment('Paraf per item informasi');

            // WALI YANG MENYATAKAN
            $table->string('wali_nama')->nullable()->comment('Nama pihak yang menyatakan persetujuan');
            $table->integer('wali_umur')->nullable()->comment('Umur pihak yang menyatakan persetujuan');
            $table->enum('wali_jk', ['L', 'P'])->nullable()->comment('Jenis Kelamin pihak yang menyatakan');
            $table->text('wali_alamat')->nullable()->comment('Alamat pihak yang menyatakan');
            $table->string('wali_jenis_identitas')->nullable()->comment('Jenis Identitas (KTP/SIM/Paspor)');
            $table->string('wali_identitas')->nullable()->comment('No Identitas pihak yang menyatakan');
            $table->string('wali_hubungan')->nullable()->comment('Hubungan dengan pasien (diri sendiri/suami/istri/dll)');
            $table->string('wali_hubungan_lainnya')->nullable()->comment('Hubungan dengan pasien (lainnya)');
            
            // PERNYATAAN (SETUJU / TIDAK SETUJU)
            $table->enum('pernyataan_tindakan', ['SETUJU', 'TIDAK SETUJU'])->nullable()->comment('Menyatakan Setuju/Tidak Setuju');
            
            // CEKLIS PEMAHAMAN INFORMASI
            $table->boolean('check_received_info')->default(false)->comment('Mengakui telah menerima informasi penjelasan');
            $table->boolean('check_understand_necessity')->default(false)->comment('Memahami perlunya dan manfaat tindakan');
            $table->boolean('check_given_opportunity')->default(false)->comment('Diberikan kesempatan untuk bertanya');
            $table->boolean('check_realize_no_guarantee')->default(false)->comment('Menyadari tidak ada jaminan hasil');
            $table->boolean('check_realize_not_exact_science')->default(false)->comment('Menyadari ilmu kedokteran bukanlah ilmu pasti');

            // TANGGAL & JAM
            $table->date('tanggal_persetujuan')->nullable()->comment('Tanggal persetujuan ditandatangani');
            $table->string('jam_persetujuan')->nullable()->comment('Jam persetujuan ditandatangani');

            // TANDA TANGAN (Base64)
            $table->json('signature')->nullable()->comment('Data base64 untuk tanda tangan (Dokter, Penerima, Pembuat Pernyataan, Saksi 1, Saksi 2)');
            
            // NAMA PIHAK TANDA TANGAN
            $table->string('yang_menyatakan_nama')->nullable()->comment('Nama yang menyatakan (di bawah TTD)');
            $table->string('saksi_1_nama')->nullable()->comment('Nama Saksi 1');
            $table->string('saksi_2_nama')->nullable()->comment('Nama Saksi 2');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_consents');
    }
};
