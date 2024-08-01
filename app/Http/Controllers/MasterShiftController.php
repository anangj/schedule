<?php

namespace App\Http\Controllers;

use App\Models\MasterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MasterShiftController extends Controller
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
                'name' => 'Shift',
                'url' => route('shift.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $shift = MasterShift::all();
        // dd($shift);

        return view('shift.index', [
            'shifts' => $shift,
            'breadcrumbsItems' => $breadcrumbsItems,
            'pageTitle' => 'Shift'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
