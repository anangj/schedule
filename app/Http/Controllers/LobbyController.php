<?php

namespace App\Http\Controllers;

use App\Models\lobby;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterDokter;

class LobbyController extends Controller
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
                'name' => 'Konten',
                'url' => route('lobby.index'),
                'active' => false,
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true,
            ],
        ];

        $doctors = MasterDokter::with(['schedule' => function ($query) {
        }])
        ->where('isLobby' , '=', 1)
        ->orderBy('spesialis')
        ->get();
        // dd($doctors);

        $data = $doctors->map(function ($doctor) {

            $nama_dokter = $doctor->nama_dokter;
            $spesialis = $doctor->spesialis;
            // dd($doctor);
            $formatted_name = preg_replace('/(.*), (.*), (dr.|drg)/', '$3 $1, $2', $nama_dokter);

            $grouped_schedules = [];

            if ($spesialis === 'Anastesi') {
                $grouped_schedules = $doctor->schedule->groupBy('weekday')->map(function ($daySchedules) {
                    return $daySchedules->map(function ($schedule) {
                        return [
                            'start_hour' => '0',
                            'start_minute' => '0',
                            'end_hour' => '0',
                            'end_minute' => '0',
                            'status' => $schedule->status,
                            'appointment' => 1,
                        ];
                    });
                });
            } else {
                // Group schedules by weekday
                $grouped_schedules = $doctor->schedule->groupBy('weekday')->map(function ($daySchedules) {
                    return $daySchedules->map(function ($schedule) {
                        return [
                            'start_hour' => $schedule->start_hour,
                            'start_minute' => $schedule->start_minute,
                            'end_hour' => $schedule->end_hour,
                            'end_minute' => $schedule->end_minute,
                            'status' => $schedule->status,
                            'appointment' => $schedule->appointment,
                        ];
                    });
                });
            }

            return [
                // 'nama_dokter' => $formatted_name,
                'nama_dokter' => $doctor->nama_dokter,
                'poli' => $doctor->poli,
                'spesialis' => $doctor->spesialis,
                'image_url' => $doctor->image_url,
                'id_tera' => $doctor->id_tera,
                'schedules' => $grouped_schedules
            ];
        });
        // dd($data);

        return view('lobby.lobby', [
            'data' => $data,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'List Konten',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lobby.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(lobby $lobby)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(lobby $lobby)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, lobby $lobby)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(lobby $lobby)
    {
        //
    }
}
