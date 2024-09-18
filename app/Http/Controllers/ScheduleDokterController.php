<?php

namespace App\Http\Controllers;

use App\Models\ScheduleDokter;
use App\Models\MasterDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleDokterController extends Controller
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
                'name' => 'Schedule Dokter',
                'url' => route('schedule-dokters.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        $schedules = ScheduleDokter::with('masterDokter')
        ->whereHas('masterDokter', function($query) {
            $query->where('isLobby', '=', 1);
        });

        // Apply filters based on request parameters
        if ($request->filled('doctor_name')) {
            $schedules->whereHas('masterDokter', function ($q) use ($request) {
                $q->where('nama_dokter', 'like', '%' . $request->input('doctor_name') . '%');
            });
        }

        if ($request->filled('specialization')) {
            $schedules->whereHas('masterDokter', function ($q) use ($request) {
                $q->where('spesialis', 'like', '%' . $request->input('specialization') . '%');
            });
        }

        if ($request->filled('weekday')) {
            $schedules->where('weekday', $request->input('weekday'));
        }

        // Get the filtered results
        $data = $schedules->get();

        // dd($data[0]);
        return view('schedules.index', [
            'data' => $data,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Schedule Doctor'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbsItems = [
            [
                'name' => 'Schedule Dokter',
                'url' => route('schedule-dokters.index'),
                'active' => false
            ],
            [
                'name' => 'Create',
                'url' => '#',
                'active' => true
            ],
        ];
        // Get all doctors for the select input
        $doctors = MasterDokter::where('isLobby', 1)->get();

        // Pass the doctors to the view
        return view('schedules.create', [
            'doctors' => $doctors,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Create Schedule'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // Validate the incoming request
        $request->validate([
            'doctor_id' => 'required|exists:master_dokters,id',
            'weekday' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'appointment' => 'nullable|boolean',
        ]);

        // dd($request);

        // Extract hour and minute from 'start_time' and 'end_time'
        $startTime = explode(':', $request->start_time);
        $endTime = explode(':', $request->end_time);

        // Create a new schedule
        ScheduleDokter::create([
            'doctor_id' => $request->doctor_id,
            'weekday' => $request->weekday,
            'start_hour' => $startTime[0],
            'start_minute' => $startTime[1],
            'end_hour' => $endTime[0],
            'end_minute' => $endTime[1],
            'appointment' => $request->has('appointment') ? 1 : 0,
        ]);

        // Redirect to the schedules index with a success message
        return redirect()->route('schedule-dokters.index')->with('message', 'Schedule created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScheduleDokter  $scheduleDokter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Schedule Dokter',
                'url' => route('schedule-dokters.index'),
                'active' => false
            ],
            [
                'name' => 'Show',
                'url' => '#',
                'active' => true
            ],
        ];

        $data = ScheduleDokter::with('masterDokter')->findOrFail($id);
        // dd($data);

        return view('schedules.show', [
            'data' => $data,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Schedule Doctor'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScheduleDokter  $scheduleDokter
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Schedule Dokter',
                'url' => route('schedule-dokters.index'),
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => '#',
                'active' => true
            ],
        ];

        $data = ScheduleDokter::with('masterDokter')->findOrFail($id);

        // dd($data);

        return view('schedules.edit', [
            'data' => $data,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Schedule'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScheduleDokter  $scheduleDokter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'weekday' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'appointment' => 'nullable'
        ]);

        // Find the schedule record by ID
        $schedule = ScheduleDokter::findOrFail($id);

        // Extract hour and minute from the 'start_time' and 'end_time'
        $startTime = explode(':', $request->start_time);
        $endTime = explode(':', $request->end_time);

        // Update the schedule attributes
        $schedule->weekday = $request->weekday;
        $schedule->start_hour = $startTime[0];
        $schedule->start_minute = $startTime[1];
        $schedule->end_hour = $endTime[0];
        $schedule->end_minute = $endTime[1];
        $schedule->appointment = $request->has('appointment') ? 1 : 0;

        // Update the related doctor's specialization if applicable
        // $schedule->masterDokter->spesialis = $request->spesialis;
        // $schedule->masterDokter->save();

        // Save the updated schedule
        $schedule->save();

        // Redirect back with a success message
        return redirect()->route('schedule-dokters.index')->with('message', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScheduleDokter  $scheduleDokter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Find the schedule record by ID
            $schedule = ScheduleDokter::findOrFail($id);

            // Delete the schedule record
            $schedule->delete();

            // Redirect back with a success message
            return redirect()->route('schedule-dokters.index')->with('message', 'Schedule deleted successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message if something goes wrong
            return redirect()->route('schedule-dokters.index')->with('error', 'Failed to delete the schedule. Please try again.');
        }
    }
}
