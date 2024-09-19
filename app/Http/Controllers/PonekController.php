<?php

namespace App\Http\Controllers;

use App\Models\MasterShift;
use App\Models\Ponek;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class PonekController extends Controller
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
                'name' => 'Ponek',
                'url' => route('ponek.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        $shift = MasterShift::select('name_shift','code_shift')->get();
        $listPonek = Ponek::select('employee_name')->distinct()->get();

        $data = Ponek::query();

        if ($request->filled('employee_name')) {
            $data->where('employee_name', 'like', '%' . $request->input('employee_name') . '%');
        }

        if ($request->filled('date')) {
            $data->whereDate('date', $request->input('date'));
        }

        if ($request->filled('name_shift')) {
            $data->where('shift', $request->input('name_shift'));
        }

        $poneks = $data->get();

        return view('ponek.index', [
            'poneks' => $poneks,
            'shift' => $shift,
            'listPonek' => $listPonek,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Ponek'
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

        $nod = new Ponek();
        $nod->employee_id = $validatedData['employee_id'];
        $nod->employee_name = $validatedData['employee_name'];
        $nod->date = $validatedData['date'];
        $nod->shift = $validatedData['shift'];
        $nod->save();
        return redirect()->route('ponek.index')->with('success', 'Shift created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ponek  $ponek
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Ponek',
                'url' => route('ponek.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];
        $poneks = Ponek::find($id);
        return view('ponek.show', [
            'poneks' => $poneks,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Ponek',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ponek  $ponek
     * @return \Illuminate\Http\Response
     */
    public function edit(Ponek $ponek)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Ponek',
                'url' => route('ponek.index'),
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('ponek.edit', [
            'poneks' => $ponek,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Ponek'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ponek  $ponek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ponek $ponek)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'date' => 'required|date',
            'shift' => 'required|string|max:255',
        ]);

        $ponek->employee_name = $request->employee_name;
        $ponek->date = $request->date;
        $ponek->shift = $request->shift;
        $ponek->save();

        return redirect()->route('ponek.index')->with('success', 'Ponek updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ponek  $ponek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ponek $ponek)
    {
        $ponek->delete();

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
                Ponek::whereMonth('date', $today)->delete();
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
                    $nurse = new Ponek();
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
        $filePath = storage_path('template/template_ponek.xlsx');

        if (File::exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'Template file not found.');
        }
    }
}
