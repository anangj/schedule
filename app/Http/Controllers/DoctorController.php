<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;

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

    /**
     * @param \App\Http\Requests\DoctorControllerUpdateRequest $request
     * @param \App\Models\Doctor $doctor
     * @return \App\Http\Resources\DoctorResource
     */
    public function update(DoctorUpdateRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated());

        return new DoctorResource($doctor);
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

    public function storeJson(Request $request)
    {
        $json = File::get($request->file('json_file'));
        $datas = json_decode($json, true);
        

        foreach ($datas as $data) {
            // var_dump($data['schedule']);
            $doctor = new Doctor();
            $doctor->doctor_id = $data['doctor_id'];
            $doctor->doctor_name = $data['nama_doctor'];
            $doctor->poli = $data['poli'];
            $doctor->specialist = $data['specialist'];
            $doctor->save();

            foreach ($data['schedule'] as $scheduleData) {
                if ($scheduleData !== null) {
                    $schedule = new Schedule();
                    $schedule->doctor_id = $doctor->id; // Assuming id is auto-incremented
                    $schedule->weekday = $scheduleData['weekday'];
                    $schedule->start_hour = $scheduleData['start_hour'];
                    $schedule->start_minute = $scheduleData['start_minute'];
                    $schedule->end_hour = $scheduleData['end_hour'];
                    $schedule->end_minute = $scheduleData['end_minute'];
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
    // public function storeJson(Request $request)
    // {
    //     $json = File::get($request->file('json_file'));
    //     $data = json_decode($json, true);

    //     foreach ($data as $key => $item) {
    //         $doctor = Doctor::updateOrCreate(
    //             ['doctor_id' => $item['doctor_id']],
    //             [
    //                 'doctor_name' => $item['nama_doctor'],
    //                 'poli' => $item['poli'] ,  // Gunakan nilai default atau biarkan null
    //                 'specialist' => $item['specialist'],  // Gunakan nilai default atau biarkan null
    //             ]
    //         );

    //         $this->processSchedules($doctor, $item['schedule']);
    //     }

    //     return back()->with('success', 'Doctors and schedules added successfully from JSON.');
    // }

    // private function processSchedules($doctor, $schedules)
    // {
    //     if (is_array($schedules)) {
    //         foreach ($schedules as $schedule) {
    //             if (is_array($schedule)) {
    //                 var_dump($doctor->schedules());
    //                 // $doctor->schedules()->updateOrCreate([
    //                 //     'weekday' => $schedule['weekday'],
    //                 //     'start_hour' => $schedule['start_hour'],
    //                 //     'start_minute' => $schedule['start_minute'],
    //                 //     'end_hour' => $schedule['end_hour'],
    //                 //     'end_minute' => $schedule['end_minute'],
    //                 // ]);
    //             }
    //         }
    //     }
    // }

    //     public function storeJson(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $json = File::get($request->file('json_file'));
    //         $data = json_decode($json, true);

    //         foreach ($data as $key => $item) {
    //             $doctor = Doctor::updateOrCreate(
    //                 ['doctor_id' => $item['doctor_id']],
    //                 [
    //                     'doctor_name' => $item['nama_doctor'],
    //                     'poli' => $item['poli'] ?? 'Default Poli',
    //                     'specialist' => $item['specialist'] ?? 'General',
    //                 ]
    //             );

    //             if (!empty($item['schedule']) && is_array($item['schedule'])) {
    //                 foreach ($item['schedule'] as $schedule) {
    //                     if ($schedule) {
    //                         $doctor->schedules()->updateOrCreate([
    //                             'weekday' => $schedule['weekday'],
    //                             'start_hour' => $schedule['start_hour'],
    //                             'start_minute' => $schedule['start_minute'],
    //                             'end_hour' => $schedule['end_hour'],
    //                             'end_minute' => $schedule['end_minute'],
    //                         ]);
    //                     }
    //                 }
    //             }
    //         }

    //         DB::commit();
    //         return back()->with('success', 'Doctors and schedules added successfully from JSON.');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return back()->with('error', 'Error processing JSON: ' . $e->getMessage());
    //     }
    // }

    ///this function for insert into mognodb
    // public function storeJson(Request $request)
    // {
    //     $json = File::get($request->file('json_file'));
    //     $jsonData = json_decode($json, true);
    //     // var_dump($jsonData);
    //     foreach ($jsonData as $key => $doctorData) {
    //         $doctor = new Doctor();
    //         $doctor->doctor_id = $doctorData['doctor_id'];
    //         $doctor->doctor_personal = [
    //             'doctor_name' => $doctorData['nama_doctor'],
    //             'specialities' => [
    //                 'speciality_name' => $doctorData['specialist']
    //             ]
    //         ];


    //         $doctor->doctor_job = [
    //             'poli' => $doctorData['poli'],
    //             'hospital' => array_map(function ($hospital) use ($doctorData) {
    //                 return [
    //                     'hospital_id' => $hospital['hospital_id'],
    //                     'hospital_name' => $hospital['hospital_name'],
    //                     'schedules' => array_map(function ($schedule) {
    //                         return [
    //                             'day' => $schedule['weekday'] ?? null,
    //                             'start_hour' => $schedule['start_hour'] ?? null,
    //                             'start_minute' => $schedule['start_minute'] ?? null,
    //                             'end_hour' => $schedule['end_hour'] ?? null,
    //                             'end_minute' => $schedule['end_minute'] ?? null
    //                         ];
    //                     }, $doctorData['schedule'] ?? []),
    //                 ];
    //             }, $doctorData['hospitals']),
    //         ];



    //         $doctor->save();
    //     }
    //     // return redirect()->route('doctors.index');

    //     // foreach ($jsonData as $key => $doctorData) {
    //     //     // Create Doctor record
    //     //     $doctor = new Doctor();
    //     //     $doctor->doctor_id = $doctorData['doctor_id'];
    //     //     $doctor->doctor_name = $doctorData['nama_doctor'];
    //     //     $doctor->poli = $doctorData['poli'];
    //     //     $doctor->specialist = $doctorData['specialist'];
    //     //     $doctor->save();


    //     //     // Create Schedule records
    //     //     foreach ($doctorData['schedule'] as $scheduleData) {
    //     //         if ($scheduleData !== null) {
    //     //             $schedule = new Schedule();
    //     //             $schedule->doctor_id = $doctor->id; // Assuming id is auto-incremented
    //     //             $schedule->weekday = $scheduleData['weekday'];
    //     //             $schedule->start_hour = $scheduleData['start_hour'];
    //     //             $schedule->start_minute = $scheduleData['start_minute'];
    //     //             $schedule->end_hour = $scheduleData['end_hour'];
    //     //             $schedule->end_minute = $scheduleData['end_minute'];
    //     //             $schedule->save();
    //     //         }
    //     //     }
    //     // }
    // }
}
