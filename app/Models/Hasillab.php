<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hasillab extends Model
{
    use HasFactory;
    protected $table = 'hasillab';

    protected $fillable = [
        'no_bpjs',
        'nama',
        'keterangan',
        'tanggal_pemeriksaan',
        'hasil_lab',
        'catatan',
    ];

    protected $casts = [
        'data_pemeriksaan' => 'array',
    ];

    public $timestamps = true;

    // app/Models/hasillab.php
    public function pasien()
    {
        return $this->belongsTo(pasien::class, 'no_bpjs', 'no_bpjs');
    }

}
