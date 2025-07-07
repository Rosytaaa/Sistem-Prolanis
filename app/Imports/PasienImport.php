<?php

namespace App\Imports;

use App\Models\pasien;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;
use Exception;

class PasienImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $tanggalLahir = null;

        try {
            if (is_numeric($row['tanggal_lahir'])) {
                $tanggalLahir = ExcelDate::excelToDateTimeObject($row['tanggal_lahir']);
            } else {
                $tanggalLahir = Carbon::createFromFormat('Y/m/d', $row['tanggal_lahir']);
            }
        } catch (Exception $e) {
            $tanggalLahir = null;
        }

        $validGenders = ['Laki-laki', 'Perempuan'];
        $jenisKelamin = in_array($row['jenis_kelamin'], $validGenders) ? $row['jenis_kelamin'] : null;

        return new pasien([
            'no_bpjs'        => $row['no_bpjs'],
            'nama'           => $row['nama'],
            'jenis_kelamin'  => $jenisKelamin,
            'tanggal_lahir'  => $tanggalLahir ? $tanggalLahir->format('Y-m-d') : null,
            'keterangan'     => $row['keterangan'],
            'no_telp'        => $row['no_telepon'],
            'alamat'         => $row['alamat'],
        ]);
    }
}
