<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pasien;
use App\Models\Hasillab;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Imports\HasillabImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HasillabExport;

class HasillabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $barisdata = 10; // jumlah per halaman
        $katakunci = $request->katakunci;

        $query = hasillab::query();

        if (strlen($katakunci)) {
            $query->where(function ($q) use ($katakunci) {
                $q->where('no_bpjs', 'like', "%$katakunci%")
                ->orWhere('nama', 'like', "%$katakunci%");
            });
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Filter berdasarkan tanggal pemeriksaan
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pemeriksaan', $request->tanggal);
        }

        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'like', '%' . $request->keterangan . '%');
        }

        $hasil = $query->paginate($barisdata);
        return view('hasillab')->with('hasil', $hasil);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasien = pasien::all(); // ambil semua data pasien
        return view('createhasillab', compact('pasien'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_bpjs'=> 'required',
            'nama'=> 'required',
            'keterangan'=> 'required',
            'tanggal_pemeriksaan'=> 'required',
            'jenis_pemeriksaan'=> 'required',
            'hasil_pemeriksaan'=> 'required',

        ],
        [
            'no_bpjs.required' =>'No BPJS wajib disi',
            'nama.required' =>'Nama wajib disi',
            'keterangan.required' =>'Keterangan wajib disi',
            'jenis_pemeriksaan.required' =>'Jenis Pemeriksaan wajib diisi',
            'hasil_pemeriksaan.required' => 'Hasil Pemeriksaan wajib diiai',
        ]
    );

        $gabung = [];
        foreach ($request->jenis_pemeriksaan as $i => $jenis) {
            $hasil = $request->hasil_pemeriksaan[$i];
            $gabung[] = "$jenis = $hasil";
        }

        $pemeriksaan = implode('; ', $gabung);

        $hasil = [
            'no_bpjs' => $request->no_bpjs,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'hasil_lab' => $pemeriksaan,
            'catatan' =>$request->catatan
        ];

        hasillab::create($hasil);
        return redirect()->to('hasillab')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = hasillab::with('pasien')->findOrFail($id);
        return view('detailhasil', compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hasillab = hasillab::with('pasien')->findOrFail($id);
        $pasien = pasien::all();
        $rawHasil = $hasillab->hasil_lab; // string dari database
        $hasil_array = [];

        if ($rawHasil) {
            $pemeriksaans = explode(';', $rawHasil);

            foreach ($pemeriksaans as $p) {
                $bagian = explode('=', $p);
                if (count($bagian) == 2) {
                    $hasil_array[] = [
                        'jenis' => trim($bagian[0]),
                        'hasil' => trim($bagian[1])
                    ];
                }
            }
        }

        $hasillab->hasil_array = $hasil_array;
        return view('edithasillab', compact('hasillab', 'pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'no_bpjs'=> 'required',
        'nama'=> 'required',
        'keterangan'=> 'required',
        'tanggal_pemeriksaan'=> 'required',
        'jenis_pemeriksaan'=> 'required',
        'hasil_pemeriksaan'=> 'required',

    ],
    [
        'no_bpjs.required' =>'No BPJS wajib disi',
        'nama.required' =>'Nama wajib disi',
        'keterangan.required' =>'Keterangan wajib disi',
        'jenis_pemeriksaan.required' =>'Jenis Pemeriksaan wajib diisi',
        'hasil_pemeriksaan.required' => 'Hasil Pemeriksaan wajib diiai',
    ]
        );

    $gabung = [];
    foreach ($request->jenis_pemeriksaan as $i => $jenis) {
        $hasil = $request->hasil_pemeriksaan[$i];
        $gabung[] = "$jenis = $hasil";
    }

    $pemeriksaan = implode('; ', $gabung);

    $hasil = [
        'no_bpjs' => $request->no_bpjs,
        'nama' => $request->nama,
        'keterangan' => $request->keterangan,
        'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
        'hasil_lab' => $pemeriksaan,
        'catatan' =>$request->catatan
    ];
        hasillab::where('id', $id)->update($hasil);
        return redirect()->to('hasillab')->with('success', 'Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = HasilLab::findOrFail($id);
        $data->delete();

    return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

     public function export()
    {
        return Excel::download(new HasillabExport, 'Hasillab.xlsx');
    }
     public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new HasillabImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data pasien berhasil diimport.');
    }
}
