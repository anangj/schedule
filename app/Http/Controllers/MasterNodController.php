<?php

namespace App\Http\Controllers;

use App\Models\MasterNod;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MasterNodController extends Controller
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
                'name' => 'Nod',
                'url' => route('nod.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        $data = DB::select('select * from master_nods');
        // dd($data);

        return view('master-nod.index', [
            'data' => $data,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Master Nod'
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
     * @param  \App\Models\MasterNod  $masterNod
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Nod',
                'url' => route('master-nod.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];
        
        $masterNod = MasterNod::find($id);
        return view('master-nod.show', [
            'masterNod' => $masterNod,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Master Nod',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterNod  $masterNod
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterNod $masterNod)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Nod',
                'url' => route('master-nod.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('master-nod.edit', [
            'masterNod' => $masterNod,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Master Nurse'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterNod  $masterNod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterNod $masterNod)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'employee_id' => 'nullable|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update doctor information
        $masterNod->employee_name = $request->employee_name;
        $masterNod->employee_id = $request->employee_id;
        // Handle file upload
        if ($request->hasFile('image_url')) {
            // Delete the old image if it exists
            if ($masterNod->image_url) {
                Storage::disk('public')->delete($masterNod->image_url);
            }

            // Store the new image in the 'public/images/dokter' directory
            $path = $request->file('image_url')->store('images/nod', 'public');

            // Save the image path in the database
            $masterNod->image_url = $path;
        }

        // Save the updated doctor information
        $masterNod->save();

        return redirect()->route('master-nod.index')->with('success', 'Nod updated successfully', compact('masterNod'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterNod  $masterNod
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterNod $masterNod)
    {
        //
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
                    $nurse = new MasterNod();
                    $nurse->employee_id = $employeeId;
                    $nurse->employee_name = $employeeName;
                    $nurse->save();
                // }
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('master-nod.index');
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
