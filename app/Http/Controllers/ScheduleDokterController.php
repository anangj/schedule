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
    public function index()
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
        })
        ->get();

        // dd($schedules[0]);
        return view('schedules.index', [
            'data' => $schedules,
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
