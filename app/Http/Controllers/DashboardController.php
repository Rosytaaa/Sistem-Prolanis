<?php

namespace App\Http\Controllers;

use App\Models\pasien;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
        public function index()
    {
        $totalDiabetes = pasien::where('keterangan', 'diabetes melitus')->count();
        $totalHipertensi = pasien::where('keterangan', 'hipertensi')->count();
        $totalKeduanya = pasien::where('keterangan', 'diabetes melitus dan hipertensi')->count();
        $totalPasien = pasien::count();

        $pemeriksaanPerBulan = DB::table('hasillab')
            ->selectRaw("DATE_FORMAT(tanggal_pemeriksaan, '%Y-%m') as bulan, COUNT(*) as jumlah")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('mainlayout', compact(
            'totalDiabetes',
            'totalHipertensi',
            'totalKeduanya',
            'totalPasien',
            'pemeriksaanPerBulan'
        ));
    }
}
