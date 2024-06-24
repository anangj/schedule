<?php

namespace App\Http\Controllers;

use App\Models\ScheduleDokter;
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
        $schedules = DB::select('SELECT * FROM schedule_dokters');
        // dd($schedules);
        return view('schedules.index', compact('schedules'));
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
    public function show(ScheduleDokter $scheduleDokter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScheduleDokter  $scheduleDokter
     * @return \Illuminate\Http\Response
     */
    public function edit(ScheduleDokter $scheduleDokter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScheduleDokter  $scheduleDokter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScheduleDokter $scheduleDokter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScheduleDokter  $scheduleDokter
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScheduleDokter $scheduleDokter)
    {
        //
    }
}
