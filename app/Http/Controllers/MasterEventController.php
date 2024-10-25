<?php

namespace App\Http\Controllers;

use App\Models\MasterEvent;
use App\Http\Requests\StoreMasterEventRequest;
use App\Http\Requests\UpdateMasterEventRequest;

class MasterEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master-event.index');
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
     * @param  \App\Http\Requests\StoreMasterEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterEventRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterEvent  $masterEvent
     * @return \Illuminate\Http\Response
     */
    public function show(MasterEvent $masterEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterEvent  $masterEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterEvent $masterEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterEventRequest  $request
     * @param  \App\Models\MasterEvent  $masterEvent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterEventRequest $request, MasterEvent $masterEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterEvent  $masterEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterEvent $masterEvent)
    {
        //
    }
}
