<?php

namespace App\Http\Controllers;

use App\Models\MasterNurse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        // dd($data);

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
        $breadcrumbsItems = [
            [
                'name' => 'Master Nurse',
                'url' => route('master-nurses.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];
        
        $masterNurse = MasterNurse::find($id);
        return view('master-nurse.show', [
            'masterNurse' => $masterNurse,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Master Nurses',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterNurse $masterNurse)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Nurse',
                'url' => route('master-nurses.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('master-nurse.edit', [
            'masterNurse' => $masterNurse,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Master Nurse'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterNurse $masterNurse)
    {
        // dd($request);
        // Validate the request
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'employee_id' => 'nullable|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update doctor information
        $masterNurse->employee_name = $request->employee_name;
        $masterNurse->employee_id = $request->employee_id;
        // Handle file upload
        if ($request->hasFile('image_url')) {
            // Delete the old image if it exists
            if ($masterNurse->image_url) {
                Storage::disk('public')->delete($masterNurse->image_url);
            }

            // Store the new image in the 'public/images/dokter' directory
            $path = $request->file('image_url')->store('images/nurse', 'public');

            // Save the image path in the database
            $masterNurse->image_url = $path;
        }

        // Save the updated doctor information
        $masterNurse->save();

        return redirect()->route('master-nurses.index')->with('success', 'Doctor updated successfully', compact('masterNurse'));
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
                // for ($j = 2; $j < count($headers); $j++) {
                    // Memproses data 
                    $nurse = new MasterNurse();
                    $nurse->employee_id = $employeeId;
                    $nurse->employee_name = $employeeName;
                    // dd($nurse);
                    $nurse->save();
                // }
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('master-nurses.index');
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
