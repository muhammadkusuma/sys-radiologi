<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id()->comment('ID unik pasien');
            $table->string('medical_record_number')->unique()->comment('Nomor Rekam Medis (RM) unik pasien');
            $table->string('name')->comment('Nama lengkap pasien');
            $table->enum('gender', ['L', 'P'])->nullable()->comment('Jenis kelamin pasien: L (Laki-laki) atau P (Perempuan)');
            $table->date('date_of_birth')->nullable()->comment('Tanggal lahir pasien');
            $table->string('phone')->nullable()->comment('Nomor telepon pasien');
            $table->text('address')->nullable()->comment('Alamat tempat tinggal pasien');
            $table->timestamps();
            $table->softDeletes()->comment('Waktu penghapusan soft delete pasien');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
