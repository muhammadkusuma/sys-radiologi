<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->string('medical_record_number')
                ->unique();

            $table->string('name');

            $table->enum('gender', [
                'L',
                'P',
            ])->nullable();

            $table->date('date_of_birth')
                ->nullable();

            $table->string('phone')
                ->nullable();

            $table->text('address')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
