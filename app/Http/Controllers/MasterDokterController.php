<?php

namespace App\Http\Controllers;

use App\Models\MasterDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\ScheduleDokter;
use Illuminate\Support\Facades\DB;

class MasterDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterDokter::all();

        // $data = DB::select("select md.nama_dokter ,md.poli ,md.spesialis , sd.weekday ,sd.start_hour ,sd.end_hour ,sd.start_minute ,sd.end_minute , sd.status  from master_dokters md inner join schedule_dokters sd on md.id = sd.doctor_id");
        return view('master-dokter.index', compact('data'));
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
     * @param  \App\Models\MasterDokter  $masterDokter
     * @return \Illuminate\Http\Response
     */
    public function show(MasterDokter $masterDokter)
    {
        
        // $dokter = DB::select("select nama_dokter ,poli ,spesialis from master_dokters where id = '$masterDokter'");
        $masterDokter->load('schedule');
        // dd($masterDokter->nama_dokter);
        return view('master-dokter.show', compact('masterDokter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterDokter  $masterDokter
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterDokter $masterDokter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterDokter  $masterDokter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterDokter $masterDokter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterDokter  $masterDokter
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterDokter $masterDokter)
    {
        //
    }

    public function storeJson(Request $request)
    {
        $json = File::get($request->file('json_file'));
        $datas = json_decode($json, true);
        // dd($datas);


        foreach ($datas as $data) {
            $doctor = new MasterDokter();
            $doctor->id_tera = $data['doctor_id'];
            $doctor->nama_dokter = $data['nama_doctor'];
            $doctor->poli = $data['poli'];
            $doctor->spesialis = $data['specialist'];
            $doctor->save();

            foreach ($data['schedule'] as $scheduleData) {
                if ($scheduleData !== null) {
                    $schedule = new ScheduleDokter();
                    $schedule->doctor_id = $doctor->id; // Assuming id is auto-incremented
                    $schedule->weekday = $scheduleData['weekday'];
                    $schedule->start_hour = $scheduleData['start_hour'];
                    $schedule->end_hour = $scheduleData['end_hour'];
                    $schedule->start_minute = $scheduleData['start_minute'];
                    $schedule->end_minute = $scheduleData['end_minute'];
                    $schedule->status = true;
                    $schedule->save();
                }
            }
        }
        // return back()->with('success', 'Doctors added successfully from JSON.');
    }
}
