<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pasien extends Model
{
    use HasFactory;
    protected $fillable = ['no_bpjs','nama', 'jenis_kelamin','tanggal_lahir','keterangan','no_telepon','alamat'];
    protected $table = 'pasien';
    public $timestamps = true; 
}
