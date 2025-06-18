<?php

namespace App\Imports;

use App\Models\Hasillab;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;
use Exception;

class HasillabImport implements ToModel, WithHeadingRow
{
        public function model(array $row)
    {
        return new Hasillab([
            'no_bpjs'             => $row['no_bpjs'],
            'nama'                => $row['nama'],
            'keterangan'          => $row['keterangan'],
            'tanggal_pemeriksaan' => $this->transformDate($row['tanggal_pemeriksaan']),
            'hasil_lab'           => $row['hasil_lab'],
            'catatan'             => $row['catatan'],
        ]);
    }

    private function transformDate($value)
    {
        try {
            if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $value)) {
                return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            }

            if (is_numeric($value)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('Y-m-d');
            }
            
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

}
