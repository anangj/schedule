<?php

namespace App\Http\Controllers;

use App\Models\MasterShift;
use App\Models\Nod;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class NodController extends Controller
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

        $shift = MasterShift::select('name_shift','code_shift')->get();
        $listNod =  Nod::select('employee_name')->distinct()->get();

        $data = Nod::query();

        if ($request->filled('employee_name')) {
            $data->where('employee_name', 'like', '%' . $request->input('employee_name') . '%');
        }

        if ($request->filled('date')) {
            $data->whereDate('date', $request->input('date'));
        }

        if ($request->filled('name_shift')) {
            $data->where('shift', $request->input('name_shift'));
        }

        $nods = $data->get();

        return view('nod.index', [
            'nods' => $nods,
            'shift' => $shift,
            'listNod' => $listNod,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Nod'
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
        $validatedData = $request->validate([
            'employee_id' => 'required|string|max:255',
            'employee_name' => 'required|string|max:255',
            'date' => 'required|date_format:H:i',
            'shift' => 'required|date_format:H:i',
        ]);

        $nod = new Nod();
        $nod->employee_id = $validatedData['employee_id'];
        $nod->employee_name = $validatedData['employee_name'];
        $nod->date = $validatedData['date'];
        $nod->shift = $validatedData['shift'];
        $nod->save();
        return redirect()->route('nod.index')->with('success', 'Shift created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nod  $nod
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $nurses = Nod::find($id);
        return view('nod.show', [
            'nods' => $nurses,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Nod',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nod  $nod
     * @return \Illuminate\Http\Response
     */
    public function edit(Nod $nod)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Nod',
                'url' => route('nod.index'),
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('nod.edit', [
            'nods' => $nod,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Nod'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nod  $nod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nod $nod)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'date' => 'required|date',
            'shift' => 'required|string|max:255',
        ]);

        $nod->employee_name = $request->employee_name;
        $nod->date = $request->date;
        $nod->shift = $request->shift;
        $nod->save();

        return redirect()->route('nod.index')->with('success', 'Nod updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nod  $nod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nod $nod)
    {
        $nod->delete();

        return response()->noContent();
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

            // Mendapatkan header
            $headers = $rows[0][$headerRowNumber];

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

            $dateMonth = convertDate($headers[3]);
            $month = Carbon::parse($dateMonth)->month;

            if ($today === $month) {
                Nod::whereMonth('date', $today)->delete();
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
                    $nurse = new Nod();
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
        return redirect()->route('nod.index');
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
        $filePath = storage_path('app/templates/template_nod.xlsx');

        if (File::exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'Template file not found.');
        }
    }
}
