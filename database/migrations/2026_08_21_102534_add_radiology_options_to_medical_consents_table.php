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
        Schema::table('medical_consents', function (Blueprint $table) {
            $table->json('alternative_treatment_choices')->nullable()->after('alternative_treatment_detail');
            $table->string('risk_if_not_treated_option')->nullable()->after('alternative_treatment_choices');
            $table->string('risk_if_not_treated_detail')->nullable()->after('risk_if_not_treated_option');
            $table->json('risk_if_not_treated_choices')->nullable()->after('risk_if_not_treated_detail');
            $table->string('hospitalization_option')->nullable()->after('risk_if_not_treated_choices');
            $table->unsignedInteger('hospitalization_days')->nullable()->after('hospitalization_option');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_consents', function (Blueprint $table) {
            $table->dropColumn([
                'alternative_treatment_choices',
                'risk_if_not_treated_option',
                'risk_if_not_treated_detail',
                'risk_if_not_treated_choices',
                'hospitalization_option',
                'hospitalization_days',
            ]);
        });
    }
};
