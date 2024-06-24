<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\MasterDokter;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;
use Maatwebsite\Excel\Facades\Excel;

class DoctorController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DoctorCollection
     */
    public function index(Request $request)
    {
        // $doctors = Doctor::where('doctor_id', 'I12345')->get();
        // var_dump($doctors);

        // $doctors = Doctor::all(); ///this is for mongodb

        $doctors = Doctor::all();
        return view('doctors.index', ['doctors' => $doctors]);

        // return new DoctorCollection($doctors);
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
        $doctor = new Doctor();

        $doctor->doctor_id = $request['doctor_id'];

        $doctor->doctor_personal = [
            'doctor_name' => $request['namaDokter'],
            'id_card' => $request['idCard'],
            'doctor_title' => $request['titleDokter'],
            'speciality_name' => $request['specialities'],
            'medical_education' => $request['medicalEducation'],
            'medical_degree' => $request['medicalDegree'],
            'ceritification' => [
                'certification_name' => $request['certification']
            ]
        ];

        var_dump($doctor->doctor_personal);
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
        // var_dump($doctors);
        return view('doctors.show', compact('doctors'));
    }

    public function edit( Doctor $doctor)
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
                $doctor = new Doctor();
                $doctor->employee_id = $employeeId;
                $doctor->employee_name = $employeeName;
                $doctor->shift = $attendance;
                $doctor->date = $date;
                $doctor->save();
            }
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

        // foreach ($data as $item) {
        //     $doctor = Doctor::create([
        //         'doctor_id' => $item->doctor_id,
        //         'doctor_name' => $item->nama_doctor,
        //         'poli' => $item->poli,
        //         'specialist' => $item->specialist
        //     ]);

        //     // Periksa jika 'schedule' ada dan adalah array
        //     if (!empty($item['schedule']) && is_array($item['schedule'])) {
        //         foreach ($item['schedule'] as $schedule) {
        //             // Pastikan schedule bukan null dan adalah array
        //             if (is_array($schedule)) {
        //                 $doctor->schedules()->create([
        //                     'weekday' => $schedule['weekday'] ?? 'Unknown Day',  // Gunakan nilai default jika null
        //                     'start_hour' => $schedule['start_hour'] ?? 0,  // Gunakan nilai default jika null
        //                     'start_minute' => $schedule['start_minute'] ?? 0,  // Gunakan nilai default jika null
        //                     'end_hour' => $schedule['end_hour'] ?? 0,  // Gunakan nilai default jika null
        //                     'end_minute' => $schedule['end_minute'] ?? 0,  // Gunakan nilai default jika null
        //                 ]);
        //             }
        //         }
        //     }
        // }

        // return back()->with('success', 'Doctors added successfully from JSON.');
    }
}
