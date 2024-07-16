<?php

namespace App\Http\Controllers;

use App\Http\Requests\NurseStoreRequest;
use App\Http\Requests\NurseUpdateRequest;
use App\Http\Resources\NurseCollection;
use App\Http\Resources\NurseResource;
use App\Models\Nurse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class NurseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\NurseCollection
     */
    public function index(Request $request)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Nurse',
                'url' => route('nurses.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $nurses = Nurse::whereMonth('date', $currentMonth)
        ->whereYear('date', $currentYear)
        ->get();

        return view('nurses.index', [
            'nurses' => $nurses,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Nurse'
        ]);

        // return new NurseCollection($nurses);
    }

    /**
     * @param \App\Http\Requests\NurseControllerStoreRequest $request
     * @return \App\Http\Resources\NurseResource
     */
    public function store(NurseStoreRequest $request)
    {
        $nurse = Nurse::create($request->validated());

        return new NurseResource($nurse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Nurse $nurse
     * @return \App\Http\Resources\NurseResource
     */
    public function show(Request $request, Nurse $nurse)
    {
        return new NurseResource($nurse);
    }

    /**
     * @param \App\Http\Requests\NurseControllerUpdateRequest $request
     * @param \App\Models\Nurse $nurse
     * @return \App\Http\Resources\NurseResource
     */
    public function update(NurseUpdateRequest $request, Nurse $nurse)
    {
        $nurse->update($request->validated());

        return new NurseResource($nurse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Nurse $nurse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Nurse $nurse)
    {
        $nurse->delete();

        return response()->noContent();
    }

    public function storeExcel(Request $request)
    {
        try {
            // Mengasumsikan file telah diunggah melalui form
            $file = $request->file('excel_file');

            // Memuat file
            $rows = Excel::toArray([], $file);

            // Mendapatkan nomor baris header
            $headerRowNumber = $this->getHeaderRowNumber($rows);

            // Mendapatkan header
            $headers = $rows[0][$headerRowNumber];

            // Fungsi untuk mengubah format tanggal
            function convertDate($excelDate)
            {
                // Periksa apakah tanggal dalam format angka Excel
                if (is_numeric($excelDate)) {
                    $unix_date = ($excelDate - 25569) * 86400;
                    return gmdate("Y-m-d", $unix_date);
                } else {
                    // Jika bukan angka, coba konversi langsung
                    $date = \DateTime::createFromFormat('d/m/Y', $excelDate);
                    return $date ? $date->format('Y-m-d') : $excelDate;
                }
            }

            // Melakukan iterasi melalui baris data
            for ($i = $headerRowNumber + 1; $i < count($rows[0]); $i++) {
                // Mengakses data setiap baris
                $rowData = $rows[0][$i];

                // Contoh cara mengakses data
                $employeeId = $rowData[0]; // Diasumsikan ID Karyawan adalah kolom pertama
                $employeeName = $rowData[1]; // Diasumsikan Nama Karyawan adalah kolom kedua

                // Menangani data secara dinamis berdasarkan header
                for ($j = 2; $j < count($headers); $j++) {
                    // var_dump($employeeId);
                    $date = $headers[$j]; // Diasumsikan kolom tanggal dimulai dari kolom ketiga
                    $attendance = $rowData[$j]; // Data kehadiran untuk tanggal tersebut

                    // Mengubah format tanggal
                    $formattedDate = convertDate($date);

                    // Memproses data Anda di sini
                    $nurse = new Nurse();
                    $nurse->employee_id = $employeeId;
                    $nurse->employee_name = $employeeName;
                    $nurse->date = $formattedDate;
                    $nurse->shift = $attendance;
                    $nurse->save();
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        // return redirect()
        return redirect()->route('nurses.index');
    }

    private function getHeaderRowNumber($rows)
    {
        // Melakukan iterasi melalui baris untuk menemukan baris header
        foreach ($rows[0] as $key => $row) {
            // Diasumsikan baris header mengandung "Employee ID" atau kata kunci unik lainnya
            if (in_array('Employee ID', $row)) {
                return $key;
            }
        }
        return null; // Menangani jika baris header tidak ditemukan
    }
}
