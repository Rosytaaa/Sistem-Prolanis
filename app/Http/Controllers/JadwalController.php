<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pasien;
use App\Models\jadwal;

class JadwalController extends Controller
{
    public function index(Request $request){
        $barisdata = 10;
        $katakunci = $request->katakunci;

        $query = jadwal::query();

        // Filter pencarian kata kunci (no_bpjs atau nama)
        if (strlen($katakunci)) {
            $query->where(function($q) use ($katakunci) {
                $q->where('no_bpjs', 'like', "%$katakunci%")
                ->orWhere('nama', 'like', "%$katakunci%");
            });
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('jadwal_pemeriksaan', $request->tanggal);
        }

        // Filter berdasarkan keterangan
        if ($request->filled('keterangan')) {
            $keterangan = explode(',', $request->keterangan);
            $query->where(function($q) use ($keterangan) {
                foreach ($keterangan as $ket) {
                    $q->orWhere('keterangan', 'like', "%" . trim($ket) . "%");
                }
            });
        }

        $data = $query->paginate($barisdata);
        return view('jadwalkunjungan')->with('data', $data);
    }
    public function create()
    {
        $pasien = pasien::all(); // ambil semua data pasien
        return view('createjadwal', compact('pasien'));
    }

     public function show($id)
    {
        $data = jadwal::with('pasien')->findOrFail($id);
        return view('detailjadwal', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' =>'required',
            'jadwal_pemeriksaan'=>'required',
            'no_telepon'=>'required'

        ],[
            'no_bpjs.required'=>'No BPJS wajib diisi',
            'nama.required'=>'Nama wajib diisi',
            'jadwal_pemeriksaan.required'=>'Jadwal pemeriksaan berikutnya wajib diisi',
            'no_telepon'=>'No telepon wajib diisi'
        ]);

        $data =[
            'no_bpjs'       => $request->no_bpjs,
            'nama'          => $request->nama,
            'keterangan'    => $request->keterangan,
            'no_telepon'    => $request->no_telepon,
            'jadwal_pemeriksaan'=> $request->jadwal_pemeriksaan,
            'catatan'=> $request->catatan,
        ];
        jadwal::create($data);
        return redirect()->route('jadwalkunjungan.index')->with('success', 'Berhasil menambahkan data');

    }

    public function edit(string $id)
    {
        $jadwal = jadwal::with('pasien')->findOrFail($id);
        $pasien = pasien::all();
        return view('editjadwal', compact('jadwal', 'pasien'));
    }

    public function update(Request $request, string $id)
    {
         $request->validate([
            'no_bpjs'=>'required',
            'nama' =>'required',
            'jadwal_pemeriksaan'=>'required',
            'no_telepon'=>'required'

        ],[
            'no_bpjs.required'=>'No BPJS wajib diisi',
            'nama.required'=>'Nama wajib diisi',
            'jadwal_pemeriksaan.required'=>'Jadwal pemeriksaan berikutnya wajib diisi',
            'no_telepon.required'=>'No telepon wajib diisi'
        ]);

        $data =[
            'no_bpjs'       => $request->no_bpjs,
            'nama'          => $request->nama,
            'keterangan'    => $request->keterangan,
            'no_telepon'    => $request->no_telepon,
            'jadwal_pemeriksaan'=> $request->jadwal_pemeriksaan,
            'catatan'=> $request->catatan,
        ];
        jadwal::where('id', $id)->update($data);
        return redirect()->route('jadwalkunjungan.index')->with('success', 'Berhasil melakukan update data');
    }

    public function destroy(string $id)
    {
        jadwal::where('id', $id)->delete();
        return redirect()->route('jadwalkunjungan.index')->with('success', 'Berhasil menghapus data');
    }

}
