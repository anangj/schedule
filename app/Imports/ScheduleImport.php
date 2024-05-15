<?php

namespace App\Imports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;

class ScheduleImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $employee_id = $row['employee_id'];
        $employee_name = $row['employee_name'];

        // Menghapus kolom yang sudah diketahui
        unset($row['employee_id'], $row['employee_name']);

        // Sisa $row sekarang hanya berisi tanggal dan shift
        foreach ($row as $date => $shift) {
            // Pastikan format tanggal sesuai dengan yang diharapkan
            if (Carbon::createFromFormat('Y-m-d', $date) !== false) {
                Schedule::create([
                    'employee_id'   => $employee_id,
                    'employee_name' => $employee_name,
                    'date'          => $date,
                    // 'shift'         => $shift,
                ]);
            }
        }

        return null; // Karena sudah menyimpan dalam loop
    }
}