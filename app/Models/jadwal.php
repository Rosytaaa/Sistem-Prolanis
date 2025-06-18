<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'no_bpjs',
        'nama',
        'keterangan',
        'no_telepon',
        'jadwal_pemeriksaan',
        'catatan',
    ];

     public function pasien()
    {
        return $this->belongsTo(pasien::class, 'no_bpjs', 'no_bpjs');
    }


}
