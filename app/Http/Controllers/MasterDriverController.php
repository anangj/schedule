<?php

namespace App\Http\Controllers;

use App\Models\MasterDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MasterDriverController extends Controller
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
                'name' => 'Master Driver',
                'url' => route('master-driver.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        $data = DB::select('select * from master_drivers');
        // dd($data);

        return view('master-driver.index', [
            'data' => $data,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Master Driver'
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
     * @param  \App\Models\MasterDriver  $masterDriver
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Driver',
                'url' => route('master-driver.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];
        
        $masterDriver = MasterDriver::find($id);
        return view('master-driver.show', [
            'masterDriver' => $masterDriver,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Master Driver',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterDriver  $masterDriver
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterDriver $masterDriver)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Driver',
                'url' => route('master-driver.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('master-driver.edit', [
            'masterDriver' => $masterDriver,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Master Driver'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterDriver  $masterDriver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterDriver $masterDriver)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'employee_id' => 'nullable|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update doctor information
        $masterDriver->employee_name = $request->employee_name;
        $masterDriver->employee_id = $request->employee_id;
        // Handle file upload
        if ($request->hasFile('image_url')) {
            // Delete the old image if it exists
            if ($masterDriver->image_url) {
                Storage::disk('public')->delete($masterDriver->image_url);
            }

            // Store the new image in the 'public/images/dokter' directory
            $path = $request->file('image_url')->store('images/driver', 'public');

            // Save the image path in the database
            $masterDriver->image_url = $path;
        }

        // Save the updated doctor information
        $masterDriver->save();

        return redirect()->route('master-driver.index')->with('success', 'Driver updated successfully', compact('masterDriver'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterDriver  $masterDriver
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterDriver $masterDriver)
    {
        $masterDriver->delete();
        return to_route('master-driver.index')->with('message', 'Driver deleted successfully');
    }
    public function storeExcel(Request $request) {

        try {
            // Mengasumsikan file telah diunggah melalui form
            $file = $request->file('excel_file');

            // Memuat file
            $rows = Excel::toArray([], $file);
            // dd($rows);
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
                // for ($j = 2; $j < count($headers); $j++) {
                    // Memproses data 
                    $nurse = new MasterDriver();
                    $nurse->employee_id = $employeeId;
                    $nurse->employee_name = $employeeName;
                    $nurse->save();
                // }
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('master-driver.index');
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
