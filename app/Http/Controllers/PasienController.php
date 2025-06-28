<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pasien;
use Illuminate\Validation\Rule;
use App\Imports\PasienImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PasienExport;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $barisdata = 10;
        $katakunci = $request->katakunci;

        $query = pasien::query();

        if (strlen($katakunci)) {
            $query->where(function($q) use ($katakunci) {
                $q->where('no_bpjs', 'like', "%$katakunci%")
                ->orWhere('nama', 'like', "%$katakunci%")
                ->orWhere('alamat', 'like', "%$katakunci%");
            });
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'like', '%' . $request->keterangan . '%');
        }

        $data = $query->paginate($barisdata);

        return view('menupasien')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasien = Pasien::all();
        return view('createpasien', compact('pasien'));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $request->validate([
            'no_bpjs' =>'required|numeric|unique:pasien,no_bpjs',
            'nama' =>'required',
            'alamat' =>'required',
        ],[
            'no_bpjs.required'=>'No BPJS wajib diisi',
            'no_bpjs.unique'=>'No BPJS sudah ada dalam databse',
            'nama.required'=>'Nama wajib diisi',
            'alamat.required'=>'Alamat wajib diisi',
        ]);

        $data =[
            'no_bpjs'       => $request->no_bpjs,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'keterangan'    => $request->keterangan,
            'no_telepon'    => $request->no_telepon,
            'alamat'        => $request->alamat,
        ];
        pasien::create($data);
        return redirect()->route('menupasien.index')->with('success', 'Berhasil menambahkan data');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = pasien::where('no_bpjs', $id)->first();
        return view('detailpasien', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = pasien::where('no_bpjs', $id)->first();
        return view('editpasien')->with('data', $data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'no_bpjs' => [
                'required',
                'numeric',
                Rule::unique('pasien', 'no_bpjs')->ignore($id, 'no_bpjs'),
            ],
            'nama' =>'required',
            'alamat' =>'required',
        ],[
            'no_bpjs.required'=>'No BPJS wajib diisi',
            'no_bpjs.unique'=>'No BPJS sudah ada dalam databse',
            'nama.required'=>'Nama wajib diisi',
            'alamat.required'=>'Alamat wajib diisi',
        ]);

        $data =[
            'no_bpjs'       => $request->no_bpjs,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'keterangan'    => $request->keterangan,
            'no_telepon'    => $request->no_telepon,
            'alamat'        => $request->alamat,
        ];
        pasien::where('no_bpjs', $id)->update($data);
        return redirect()->route('menupasien.index')->with('success', 'Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        pasien::where('no_bpjs', $id)->delete();
        return redirect()->to('menupasien')->with('success', 'Berhasil menghapus data');
    }

    public function export()
    {
        return Excel::download(new PasienExport, 'data_pasien.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new PasienImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data pasien berhasil diimport.');
    }

    public function diabetes()
    {
        $data = pasien::where('keterangan', 'diabetes melitus')->paginate(10); // paginasi sesuai blade kamu
        return view('menupasien', compact('data'));
    }

    public function hipertensi()
    {
        $data = pasien::where('keterangan', 'hipertensi')->paginate(10); // paginasi sesuai blade kamu
        return view('menupasien', compact('data'));
    }

    public function keduanya()
    {
        $data = pasien::where('keterangan', 'diabetes melitus dan hipertensi')->paginate(10); // paginasi sesuai blade kamu
        return view('menupasien', compact('data'));
    }

}
