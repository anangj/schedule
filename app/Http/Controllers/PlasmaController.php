<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Driver;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

class PlasmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /// for page spesialis
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
        $shiftCondition = '%L%';
        $shift = '';
        $today = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        $subQuery = DB::table('doctor_specialists')
            ->select(
                'speciality_name',
                'employee_name',
                'date',
                'shift',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY speciality_name ORDER BY employee_name) as row_num')
            )
            ->where('date', $date)
            ->where('shift', 'not like', $shiftCondition)
            ->orderBy('speciality_name')
            ->orderBy('shift');
        // dd($subQuery);

        $schedules = DB::table(DB::raw("({$subQuery->toSql()}) as ranked_doctors"))
            ->mergeBindings($subQuery)
            ->select('speciality_name', DB::raw('GROUP_CONCAT(employee_name SEPARATOR "||") as doctors'))
            ->where('row_num', '<=', 2)
            ->orderBy('speciality_name')
            ->orderBy('shift')
            ->groupBy('speciality_name')
            ->get();

        $schedules = $schedules->map(function ($item) {
            $item->doctors = explode('||', $item->doctors);
            return $item;
        });
        /// end spesialis

        /// petugas igd
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
        $doctors = [];
        $nurses = [];
        $drivers = [];

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
        /// end petugas igd

        // Combine doctors, nurses, and drivers into one collection
        $personnel = collect($doctors)->map(function ($doctor) {
            return ['type' => 'doctor', 'data' => $doctor, 'title' => 'DOCTOR'];
        })->merge(
            collect($nurses)->map(function ($nurse) {
                return ['type' => 'nurse', 'data' => $nurse, 'title' => 'NURSE'];
            })
        )->merge(
            collect($drivers)->map(function ($driver) {
                return ['type' => 'driver', 'data' => $driver, 'title' => 'DRIVER'];
            })
        );

        return view('plasma.plasma', compact('schedules', 'personnel', 'shift', 'today'));
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
