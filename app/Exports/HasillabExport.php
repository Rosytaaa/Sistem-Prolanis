<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class HasillabExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return DB::table('hasillab')
            ->leftJoin('pasien', 'hasillab.no_bpjs', '=', 'pasien.no_bpjs')
            ->select('hasillab.no_bpjs', 'hasillab.nama', 'pasien.jenis_kelamin','hasillab.keterangan','hasillab.tanggal_pemeriksaan','hasillab.hasil_lab','hasillab.catatan','pasien.tanggal_lahir', 'pasien.no_telepon','pasien.alamat')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No BPJS',
            'Nama',
            'Jenis Kelamin',
            'Keterangan',
            'Tanggal Pemeriksaan',
            'Hasil Lab',
            'Catatan',
            'Tanggal Lahir',
            'No Telepon',
            'Alamat',

        ];
    }

    public function map($row): array
    {
        return [
            ' '.(string) $row->no_bpjs,
            $row->nama,
            $row->jenis_kelamin,
            $row->keterangan,
             \Carbon\Carbon::parse($row->tanggal_pemeriksaan)->format('d/m/Y'),
            $row->hasil_lab,
            $row->catatan,
            \Carbon\Carbon::parse($row->tanggal_lahir)->format('d/m/Y'),
            ' '.(string) $row->no_telepon,
            $row->alamat,

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '62ecf5']
            ]],
        ];
    }
}
