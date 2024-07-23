<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverUpdateRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use app\Models\Driver;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $breadcrumbsItems = [
            [
                'name' => 'Driver',
                'url' => route('drivers.index'),
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

        $drivers = Driver::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get();

        return view('drivers.index', [
            'drivers' => $drivers,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Driver'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Driver',
                'url' => route('drivers.index'),
                'active' => false
            ],
            [
                'name' => 'Show',
                'url' => '#',
                'active' => true
            ],
        ];

        $driverData = Driver::find($id);
        $drivers = $driverData;

        return view('drivers.show', [
            'drivers' => $drivers,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Driver'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Driver',
                'url' => route('drivers.index'),
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('drivers.edit', [
            'drivers' => $driver,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Driver'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DriverUpdateRequest $request, Driver $driver)
    {
        // dd($request);
        $driver->update([
            'shift' => $request->validated('shift'),
            'date' => $request->validated('date')
        ]);
        return to_route('drivers.index')->with('message', 'Driver updates Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();
        return to_route('drivers.index')->with('message', 'Driver deleted successfully');
    }

    public function storeExcel(Request $request)
    {
        $today = Carbon::now()->month;
        try {
            // Mengasumsikan file telah diunggah melalui form
            $file = $request->file('excel_file');

            // Memuat file
            $rows = Excel::toArray([], $file);

            // Mendapatkan nomor baris header
            $headerRowNumber = $this->getHeaderRowNumber($rows);

            // Mendapatkan header dan menghapus nilai null di akhir
            $headers = array_filter($rows[0][$headerRowNumber], function ($header) {
                return !is_null($header);
            });

            // Reset array keys untuk memastikan indeksnya berurutan
            $headers = array_values($headers);

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

            $dateMonth = convertDate($headers[2]);
            $month = Carbon::parse($dateMonth)->month;

            if ($today === $month) {
                Driver::whereMonth('date', $today)->delete();
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
                    $drivers = new Driver();
                    $drivers->employee_id = $employeeId;
                    $drivers->employee_name = $employeeName;
                    $drivers->shift = $attendance;
                    $drivers->date = $formattedDate;
                    $drivers->save();
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('drivers.index');
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

    public function downloadTemplate()
    {
        $filePath = storage_path('app/templates/template_driver.xlsx');

        if (File::exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'Template file not found.');
        }
    }
}
