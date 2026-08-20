<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersetujuanTindakanMedis extends Model
{
    use HasFactory;

    protected $table = 'medical_consents';

    protected $fillable = [
        'patient_id',
        'doctor',
        'recipient_name',
        'relationship',
        'other_relationship',
        'diagnosis',
        'planned_procedure',
        'alternative_treatment',
        'alternative_treatment_detail',
        'diagnosis_initial',
        'wali_nama',
        'wali_umur',
        'wali_jk',
        'wali_alamat',
        'wali_jenis_identitas',
        'wali_identitas',
        'wali_hubungan',
        'wali_hubungan_lainnya',
        'pernyataan_tindakan',
        'check_received_info',
        'check_understand_necessity',
        'check_given_opportunity',
        'check_realize_no_guarantee',
        'check_realize_not_exact_science',
        'tanggal_persetujuan',
        'jam_persetujuan',
        'signature',
        'yang_menyatakan_nama',
        'saksi_1_nama',
        'saksi_2_nama',
    ];

    protected $casts = [
        'diagnosis_initial' => 'array',
        'signature' => 'array',
        'check_received_info' => 'boolean',
        'check_understand_necessity' => 'boolean',
        'check_given_opportunity' => 'boolean',
        'check_realize_no_guarantee' => 'boolean',
        'check_realize_not_exact_science' => 'boolean',
        'tanggal_persetujuan' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
