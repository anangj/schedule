<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DoctorController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DoctorCollection
     */
    public function index(Request $request)
    {
        $doctors = Doctor::all();
        // var_dump($doctors);

        return view('doctors.index', ['doctors' => $doctors]);

        // return new DoctorCollection($doctors);
    }

    /**
     * @param \App\Http\Requests\DoctorControllerStoreRequest $request
     * @return \App\Http\Resources\DoctorResource
     */
    public function store(DoctorStoreRequest $request)
    {
        $doctor = Doctor::create($request->validated());

        return new DoctorResource($doctor);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Doctor $doctor
     * @return \App\Http\Resources\DoctorResource
     */
    public function show(Request $request, Doctor $doctor)
    {
        return new DoctorResource($doctor);
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

    // public function storeJson(Request $request)
    // {
    //     $json = File::get($request->file('json_file'));
    //     $data = json_decode($json, true);
    //     // dd($data);

    //     foreach ($data as $item) {
    //         $doctor = Doctor::create([
    //             'doctor_id' => $item->doctor_id,
    //             'doctor_name' => $item->nama_doctor,
    //             'poli' => $item->poli,
    //             'specialist' => $item->specialist
    //         ]);

    //         // Periksa jika 'schedule' ada dan adalah array
    //         if (!empty($item['schedule']) && is_array($item['schedule'])) {
    //             foreach ($item['schedule'] as $schedule) {
    //                 // Pastikan schedule bukan null dan adalah array
    //                 if (is_array($schedule)) {
    //                     $doctor->schedules()->create([
    //                         'weekday' => $schedule['weekday'] ?? 'Unknown Day',  // Gunakan nilai default jika null
    //                         'start_hour' => $schedule['start_hour'] ?? 0,  // Gunakan nilai default jika null
    //                         'start_minute' => $schedule['start_minute'] ?? 0,  // Gunakan nilai default jika null
    //                         'end_hour' => $schedule['end_hour'] ?? 0,  // Gunakan nilai default jika null
    //                         'end_minute' => $schedule['end_minute'] ?? 0,  // Gunakan nilai default jika null
    //                     ]);
    //                 }
    //             }
    //         }
    //     }

    //     return back()->with('success', 'Doctors added successfully from JSON.');
    // }
    public function storeJson(Request $request)
    {
        $json = File::get($request->file('json_file'));
        $data = json_decode($json, true);

        foreach ($data as $key => $item) {
            $doctor = Doctor::updateOrCreate(
                ['doctor_id' => $item['doctor_id']],
                [
                    'doctor_name' => $item['nama_doctor'],
                    'poli' => $item['poli'] ,  // Gunakan nilai default atau biarkan null
                    'specialist' => $item['specialist'],  // Gunakan nilai default atau biarkan null
                ]
            );

            $this->processSchedules($doctor, $item['schedule']);
        }

        return back()->with('success', 'Doctors and schedules added successfully from JSON.');
    }

    private function processSchedules($doctor, $schedules)
    {
        if (is_array($schedules)) {
            foreach ($schedules as $schedule) {
                if (is_array($schedule)) {
                    $doctor->schedules()->updateOrCreate([
                        'weekday' => $schedule['weekday'],
                        'start_hour' => $schedule['start_hour'],
                        'start_minute' => $schedule['start_minute'],
                        'end_hour' => $schedule['end_hour'],
                        'end_minute' => $schedule['end_minute'],
                    ]);
                }
            }
        }
    }
}
