<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Http\Resources\ScheduleCollection;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ScheduleCollection
     */
    public function index(Request $request)
    {
        $schedules = Schedule::all();

        return view('schedules.index', ['schedules' => $schedules]);

        // return new ScheduleCollection($schedules);
    }

    /**
     * @param \App\Http\Requests\ScheduleControllerStoreRequest $request
     * @return \App\Http\Resources\ScheduleResource
     */
    public function store(Request $request)
    {
        var_dump($request->all());
        // $schedule = Schedule::create($request->validated());

        // return new ScheduleResource($schedule);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Schedule $schedule
     * @return \App\Http\Resources\ScheduleResource
     */
    public function show(Request $request, Schedule $schedule)
    {
        return new ScheduleResource($schedule);
    }

    /**
     * @param \App\Http\Requests\ScheduleControllerUpdateRequest $request
     * @param \App\Models\Schedule $schedule
     * @return \App\Http\Resources\ScheduleResource
     */
    public function update(ScheduleUpdateRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());

        return new ScheduleResource($schedule);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Schedule $schedule)
    {
        $schedule->delete();

        return response()->noContent();
    }

    public function plasmaView()
    {
        $schedules = Schedule::all();
        return view('schedules.plasma', ['schedules' => $schedules]);
    }

    public function create()
    {
        return view('schedules.create');
    }
}
