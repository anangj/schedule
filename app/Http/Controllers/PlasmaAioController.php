<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PlasmaAioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $date = Carbon::now()->format('Y-m-d');
        $date = Carbon::now()->subMonths(3)->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
        // $time = '21:30';
        $kp = '%K-P%';
        $op1 = 'OP-1';
        $op2 = 'OP-2';
        $op3 = 'OP-3';
        $p = 'P';
        $s = 'S';
        $m = 'M';
        $middle3 = 'middle-3';
        $shift = '';
        $today = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        // Schedule
        if ($time >= '07:00' && $time < '13:28') {
            $doctors = DB::select("SELECT employee_name, date, shift FROM doctors WHERE date = '$date' AND (shift LIKE '%$p%' OR shift LIKE '%$kp%')");
            $shift = 'PAGI';
        } else if ($time >= '13:30' && $time < '20:58') {
            $doctors = DB::select("SELECT employee_name, date, shift FROM doctors WHERE date = '$date' AND (shift LIKE '%$s%' OR shift LIKE '%$kp%')");
            $shift = 'SIANG';
        } else if ($time >= '21:00') {
            $doctors = DB::select("SELECT employee_name, date, shift FROM doctors WHERE date = '$date' AND (shift LIKE '%$m%')");
            $shift = 'MALAM';
        }

        // Nurses
        if ($time >= '07:00' && $time < '13:28') {
            $nurses = DB::select("SELECT employee_name, date, shift FROM nurses WHERE date = '$date' AND (shift LIKE '%$op1%')");
            $shift = 'PAGI';
        } else if ($time >= '13:30' && $time < '20:58') {
            $nurses = DB::select("SELECT employee_name, date, shift FROM nurses WHERE date = '$date' AND (shift LIKE '%$op2%')");
            $shift = 'SIANG';
        } else if ($time >= '21:00') {
            $nurses = DB::select("SELECT employee_name, date, shift FROM nurses WHERE date = '$date' AND (shift LIKE '%$op3%' OR shift LIKE '%$middle3%')");
            $shift = 'MALAM';
        }

        // dd($doctors);

        // Driver
        if ($time >= '07:00' && $time < '13:28') {
            $drivers = DB::select("SELECT employee_name, date, shift FROM drivers WHERE date = '$date' AND (shift LIKE '%$op1%')");
            $shift = 'PAGI';
        } else if ($time >= '13:30' && $time < '20:58') {
            $drivers = DB::select("SELECT employee_name, date, shift FROM drivers WHERE date = '$date' AND (shift LIKE '%$op2%')");
            $shift = 'SIANG';
        } else if ($time >= '21:00') {
            $drivers = DB::select("SELECT employee_name, date, shift FROM drivers WHERE date = '$date' AND (shift LIKE '%$op3%')");
            $shift = 'MALAM';
        }

        // dd($shift);

        return view('plasma.plasma-aio', compact( 'doctors', 'drivers', 'shift', 'today', 'nurses'));
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
