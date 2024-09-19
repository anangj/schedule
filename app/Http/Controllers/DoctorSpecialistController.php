<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\DoctorSpecialist;
use Illuminate\Support\Facades\File;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\MasterShift;


class DoctorSpecialistController extends Controller
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
                'name' => 'Doctor-Specialist',
                'url' => route('doctorSpecialist.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        // $date = Carbon::now()->subMonths(2)->format('Y-m-d');
        $shift = MasterShift::select('name_shift','code_shift')->get();
        $listDokter = DoctorSpecialist::select('employee_name')->distinct()->get();

        $data = DoctorSpecialist::query();

        if ($request->filled('employee_name')) {
            $data->where('employee_name', 'like', '%' . $request->input('employee_name') . '%');
        }

        if ($request->filled('date')) {
            $data->whereDate('date', $request->input('date'));
        }

        if ($request->filled('name_shift')) {
            $data->where('shift', $request->input('name_shift'));
        }

        $doctors = $data->get();

        // dd($doctors);
        return view('doctor-specialist.index', [
            'doctors' => $doctors,
            'shift' => $shift,
            'listDokter' => $listDokter,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Doctor Specialist'
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
        $doctorsData = DoctorSpecialist::find($id);
        $doctors = $doctorsData;

        return view('doctor-specialist.show', compact('doctors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DoctorSpecialist $doctorSpecialist)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Doctor',
                'url' => route('doctorSpecialist.index'),
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('doctor-specialist.edit', [
            'doctors' => $doctorSpecialist,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Doctor'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorUpdateRequest $request, DoctorSpecialist $doctorSpecialist)
    {
        $doctorSpecialist->update([
            'shift' => $request->validated('shift'),
            'date' => $request->validated('date')
        ]);

        return to_route('doctorSpecialist.index')->with('message', 'Doctor updates Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoctorSpecialist $doctorSpecialist)
    {
        $doctorSpecialist->delete();

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
                DoctorSpecialist::whereMonth('date', $today)->delete();
            }

            // Melakukan iterasi melalui baris data
            for ($i = $headerRowNumber + 1; $i < count($rows[0]); $i++) {
                // Mengakses data setiap baris
                $rowData = $rows[0][$i];

                // Contoh cara mengakses data
                $employeeId = $rowData[0]; // Diasumsikan ID Karyawan adalah kolom pertama
                $employeeName = $rowData[1]; // Diasumsikan Nama Karyawan adalah kolom kedua
                $specialityName = $rowData[2]; // Diasumsikan Nama Spesialisasi adalah kolom ketiga

                // Menangani data secara dinamis berdasarkan header
                for ($j = 3; $j < count($headers); $j++) {
                    // var_dump($employeeId);
                    $date = $headers[$j]; // Diasumsikan kolom tanggal dimulai dari kolom ketiga
                    $attendance = $rowData[$j]; // Data kehadiran untuk tanggal tersebut

                    // Mengubah format tanggal
                    $formattedDate = convertDate($date);

                    // Memproses data Anda di sini
                    $specialist = new DoctorSpecialist();
                    $specialist->employee_id = (string) $employeeId;
                    $specialist->employee_name = $employeeName;
                    $specialist->speciality_name = $specialityName;
                    $specialist->shift = $attendance;
                    $specialist->date = $formattedDate;
                    $specialist->save();
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('doctorSpecialist.index');
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
        $filePath = storage_path('app/templates/template_dokter_spesialis.xlsx');

        if (File::exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'Template file not found.');
        }
    }
}
