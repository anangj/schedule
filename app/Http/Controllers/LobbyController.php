<?php

namespace App\Http\Controllers;

use App\Models\lobby;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterDokter;
use App\Models\MasterEvent;
use App\Models\ContentEvent;
use Illuminate\Support\Carbon;

class LobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataToday = Carbon::now()->format('Y-m-d');
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
        ->orderBy('slide_lobby')
        ->orderBy('spesialis')
        ->get();
        // dd($doctors);
        $data = $doctors->groupBy('slide_lobby')->map(function ($group) {
            return $group->map(function ($doctor) {
                $nama_dokter = $doctor->nama_dokter;
                $spesialis = $doctor->spesialis;
        
                $formatted_name = preg_replace('/(.*), (.*), (dr.|drg)/', '$3 $1, $2', $nama_dokter);
        
                $grouped_schedules = $doctor->schedule->groupBy('weekday')->map(function ($daySchedules) use ($spesialis) {
                    return $daySchedules->map(function ($schedule) use ($spesialis) {
                        if ($spesialis === 'Anastesi') {
                            return [
                                'start_hour' => '0',
                                'start_minute' => '0',
                                'end_hour' => '0',
                                'end_minute' => '0',
                                'status' => $schedule->status,
                                'appointment' => 1,
                            ];
                        } else {
                            return [
                                'start_hour' => $schedule->start_hour,
                                'start_minute' => $schedule->start_minute,
                                'end_hour' => $schedule->end_hour,
                                'end_minute' => $schedule->end_minute,
                                'status' => $schedule->status,
                                'appointment' => $schedule->appointment,
                            ];
                        }
                    });
                });
        
                return [
                    'nama_dokter' => $doctor->nama_dokter,
                    'poli' => $doctor->poli,
                    'spesialis' => $doctor->spesialis,
                    'image_url' => $doctor->image_url,
                    'id_tera' => $doctor->id_tera,
                    'slide_lobby' => $doctor->slide_lobby,
                    'schedules' => $grouped_schedules,
                ];
            });
        });
        
        // $data = $doctors->groupBy('slide_lobby')->map(function ($doctor) {
        //     // dd($doctor);
        //     $doctor->map(function ($item) {
        //         $nama_dokter = $item->nama_dokter;
        //         $spesialis = $item->spesialis;
        //         // dd($item->nama_dokter);
        //         $formatted_name = preg_replace('/(.*), (.*), (dr.|drg)/', '$3 $1, $2', $nama_dokter);
    
        //         $grouped_schedules = [];
    
        //         if ($spesialis === 'Anastesi') {
        //             $grouped_schedules = $item->schedule->groupBy('weekday')->map(function ($daySchedules) {
        //                 return $daySchedules->map(function ($schedule) {
        //                     return [
        //                         'start_hour' => '0',
        //                         'start_minute' => '0',
        //                         'end_hour' => '0',
        //                         'end_minute' => '0',
        //                         'status' => $schedule->status,
        //                         'appointment' => 1,
        //                     ];
        //                 });
        //             });
        //         } else {
        //             // Group schedules by weekday
        //             $grouped_schedules = $item->schedule->groupBy('weekday')->map(function ($daySchedules) {
        //                 return $daySchedules->map(function ($schedule) {
        //                     return [
        //                         'start_hour' => $schedule->start_hour,
        //                         'start_minute' => $schedule->start_minute,
        //                         'end_hour' => $schedule->end_hour,
        //                         'end_minute' => $schedule->end_minute,
        //                         'status' => $schedule->status,
        //                         'appointment' => $schedule->appointment,
        //                     ];
        //                 });
        //             });
        //         }
   
        //         return [
        //             // 'nama_dokter' => $formatted_name,
        //             'nama_dokter' => $item->nama_dokter,
        //             'poli' => $item->poli,
        //             'spesialis' => $item->spesialis,
        //             'image_url' => $item->image_url,
        //             'id_tera' => $item->id_tera,
        //             'slide_lobby' => $item->slide_lobby,
        //             'schedules' => $grouped_schedules
        //         ];
        //     });
            
        // });
        // dd($data);

        // Fetch master events that are active, have a specific position, and have not ended yet.
        $masterEvents = MasterEvent::where('isActive', true)
                        ->where('positions_id', 2)
                        ->where('end_date', '>=', $dataToday)
                        ->get();

        // Extract IDs from the master events collection.
        $masterEventIds = $masterEvents->pluck('id')->toArray();

        // Fetch content events where the master_event_id is in the list of master event IDs collected above.
        $contentEvents = ContentEvent::whereIn('master_event_id', $masterEventIds)->get();

        return view('lobby.lobby', [
            'data' => $data,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'List Konten',
            'contentEvents' => $contentEvents
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
