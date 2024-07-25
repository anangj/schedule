<?php

namespace App\Http\Controllers;

use App\Models\MasterDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\ScheduleDokter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MasterDokterController extends Controller
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
                'name' => 'Master Dokter',
                'url' => route('master-dokters.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];
        $data = DB::select("select * from master_dokters where spesialis not like '%asisten%'");
        return view('master-dokter.index', [
            'data' => $data,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Master Dokter'
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
     * @param  \App\Models\MasterDokter  $masterDokter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Dokter',
                'url' => route('master-dokters.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];
        
        $masterDokter = MasterDokter::find($id);
        return view('master-dokter.show', [
            'masterDokter' => $masterDokter,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Master Doctor',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterDokter  $masterDokter
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterDokter $masterDokter)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Dokter',
                'url' => route('master-dokters.index'),
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('master-dokter.edit', [
            'masterDokter' => $masterDokter,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Master Doctor'
        ]);
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
        // dd($request);
        // Validate the request
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'poli' => 'string|max:255',
            'spesialis' => 'required|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update doctor information
        $masterDokter->nama_dokter = $request->nama_dokter;
        $masterDokter->poli = $request->poli;
        $masterDokter->spesialis = $request->spesialis;
        // Handle file upload
        if ($request->hasFile('image_url')) {
            // Delete the old image if it exists
            if ($masterDokter->image_url) {
                Storage::disk('public')->delete($masterDokter->image_url);
            }

            // Store the new image in the 'public/images/dokter' directory
            $path = $request->file('image_url')->store('images/dokter', 'public');

            // Save the image path in the database
            $masterDokter->image_url = $path;
        }

        // Save the updated doctor information
        $masterDokter->save();

        return redirect()->route('master-dokters.index')->with('success', 'Doctor updated successfully', compact('masterDokter'));

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
        // dd($request);
        $json = File::get($request->file('json_file'));
        $datas = json_decode($json, true);
        // dd($datas);


        foreach ($datas as $data) {
            $doctor = new MasterDokter();
            $doctor->id_tera = $data['doctor_id'];
            $doctor->nama_dokter = $data['nama_doctor'];
            $doctor->poli = $data['poli'];
            $doctor->spesialis = $data['specialist'];
            $doctor->image_url = $data['photo'];
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
