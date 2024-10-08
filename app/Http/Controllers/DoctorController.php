<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Doctor;
use App\Models\MasterDokter;
use App\Models\Schedule;
use App\Models\MasterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class DoctorController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DoctorCollection
     */
    public function index(Request $request)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Doctor',
                'url' => route('doctors.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        $shift = MasterShift::select('name_shift','code_shift')->get();
        $listDokter = Doctor::select('employee_name')->distinct()->get();

        $data = Doctor::query();

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

        return view('doctors.index', [
            'doctors' => $doctors, 
            'shift' => $shift,
            'listDokter' => $listDokter,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Doctor'
        ]);

    }

    public function create()
    {
        return view('doctors.create');
    }

    /**
     * @param \App\Http\Requests\DoctorStoreRequest $request
     * @return \App\Http\Resources\DoctorResource
     */
    public function store(Request $request)
    {

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Doctor $doctor
     * @return \App\Http\Resources\DoctorResource
     */
    public function show($id)
    {
        $doctorsData = Doctor::find($id);
        $doctors = $doctorsData;

        return view('doctors.show', compact('doctors'));
    }

    public function edit(Doctor $doctor)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Doctor',
                'url' => route('doctors.index'),
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('doctors.edit', [
            'doctors' => $doctor,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Doctor'
        ]);
    }

    /**
     * @param \App\Http\Requests\DoctorControllerUpdateRequest $request
     * @param \App\Models\Doctor $doctor
     * @return \App\Http\Resources\DoctorResource
     */
    public function update(DoctorUpdateRequest $request, Doctor $doctor)
    {
        // dd($request);
        $doctor->update([
            'shift' => $request->validated('shift'),
            'date' => $request->validated('date')
        ]);

        return to_route('doctors.index')->with('message', 'Doctor updates Successfully!');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Doctor $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Doctor $doctor)
    {
        $doctor->delete();

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
                Doctor::whereMonth('date', $today)->delete();
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
                    $date = $headers[$j]; // Diasumsikan kolom tanggal dimulai dari kolom ketiga
                    $attendance = $rowData[$j]; // Data kehadiran untuk tanggal tersebut

                    // Mengubah format tanggal
                    $formattedDate = convertDate($date);
                    // dd($attendance);

                    // Memproses data Anda di sini
                    $doctor = new Doctor();
                    $doctor->employee_id = $employeeId;
                    $doctor->employee_name = $employeeName;
                    $doctor->shift = $attendance;
                    $doctor->date = $formattedDate;
                    $doctor->save();
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->route('doctors.index');
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

    /**
     * Download the Excel template.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadTemplate()
    {
        $filePath = storage_path('app/templates/template_igd.xlsx');

        if (File::exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'Template file not found.');
        }
    }

    public function storeJson(Request $request)
    {
        $json = File::get($request->file('json_file'));
        $datas = json_decode($json, true);

        foreach ($datas as $data) {
            $doctor = new MasterDokter();
            $doctor->doctor_id = $data['doctor_id'];
            $doctor->doctor_name = $data['nama_doctor'];
            $doctor->poli = $data['poli'];
            $doctor->spesialis = $data['specialist'];
            $doctor->save();

            foreach ($data['schedule'] as $scheduleData) {
                if ($scheduleData !== null) {
                    $schedule = new Schedule();
                    $schedule->doctor_id = $doctor->id; // Assuming id is auto-incremented
                    $schedule->weekday = $scheduleData['weekday'];
                    $schedule->start_hour = $scheduleData['start_hour'];
                    $schedule->start_minute = $scheduleData['start_minute'];
                    $schedule->status = true;
                    $schedule->save();
                }
            }
        }
    }
}
