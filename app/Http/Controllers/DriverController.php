<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use app\Models\Driver;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // var_dump($request->filter_date);
        $date = Carbon::now()->subMonth()->format('Y-m-d');
        // $drivers = Driver::where('date', $date)->get();
        $drivers = Driver::all();
        return view ('drivers.index', compact('drivers'));
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
                'name' => 'Edit',
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeExcel(Request $request)
    {
        // Mengasumsikan file telah diunggah melalui form
        $file = $request->file('excel_file');

        // Memuat file
        $rows = Excel::toArray([], $file);

        // Mendapatkan nomor baris header
        $headerRowNumber = $this->getHeaderRowNumber($rows);

        // Mendapatkan header
        $headers = $rows[0][$headerRowNumber];
        // var_dump($headers);

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

                // Memproses data Anda di sini
                $drivers = new Driver();
                $drivers->employee_id = $employeeId;
                $drivers->employee_name = $employeeName;
                $drivers->shift = $attendance;
                $drivers->date = $date;
                // var_dump($drivers);
                $drivers->save();
            }
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
}