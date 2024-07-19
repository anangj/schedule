<?php

namespace App\Http\Controllers;

use App\Models\MasterNurse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class MasterNurseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $data = DB::select('select * from master_nurses');
        dd($data);

        return view('master-nurse.index', [
            'data' => $data,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Master Nurse'
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
        //
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

    public function storeExcel(Request $request) {
        try {
            // Mengasumsikan file telah diunggah melalui form
            $file = $request->file('excel_file');

            // Memuat file
            $rows = Excel::toArray([], $file);

            // Mendapatkan nomor baris header
            $headerRowNumber = $this->getHeaderRowNumber($rows);

            // Mendapatkan header
            $headers = $rows[0][$headerRowNumber];

            // Melakukan iterasi melalui baris data
            for ($i = $headerRowNumber + 1; $i < count($rows[0]); $i++) {
                // Mengakses data setiap baris
                $rowData = $rows[0][$i];

                // Contoh cara mengakses data
                $employeeId = $rowData[0]; // Diasumsikan ID Karyawan adalah kolom pertama
                $employeeName = $rowData[1]; // Diasumsikan Nama Karyawan adalah kolom kedua

                // Menangani data secara dinamis berdasarkan header
                for ($j = 2; $j < count($headers); $j++) {
                    // Memproses data 
                    $nurse = new MasterNurse();
                    $nurse->employee_id = $employeeId;
                    $nurse->employee_name = $employeeName;
                    $nurse->save();
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
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
