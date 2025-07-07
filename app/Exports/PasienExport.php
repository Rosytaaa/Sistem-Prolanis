<?php

namespace App\Exports;

use App\Models\pasien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PasienExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return pasien::select(
            'no_bpjs', 'nama', 'jenis_kelamin', 'tanggal_lahir',
            'keterangan', 'no_telepon', 'alamat'
        )->get();
    }

    public function headings(): array
    {
        return [
            'No BPJS',
            'Nama',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Keterangan',
            'No Telepon',
            'Alamat'
        ];
    }

    public function map($row): array
    {
        return [
            ' '.(string) $row->no_bpjs,
            $row->nama,
            $row->jenis_kelamin,
            \Carbon\Carbon::parse($row->tanggal_lahir)->format('d/m/Y'),
            $row->keterangan,
            ' '.(string) $row->no_telepon,
            $row->alamat
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
