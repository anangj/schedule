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
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
        $kp = '%K-P%';
        $op1 = 'OP-1';
        $op2 = 'OP-2';
        $op3 = 'OP-3';
        $shift = '';
        $today = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');

        // Schedule
        if ($time >= '07:00' && $time < '14:30') {
            $schedules = DB::select("SELECT employee_name, date, shift FROM doctors WHERE date = '$date' AND (shift LIKE '%$op1%' OR shift LIKE '%$kp%')");
            $shift = 'PAGI';
        } else if ($time >= '13:30' && $time < '21:00') {
            $schedules = DB::select("SELECT employee_name, date, shift FROM doctors WHERE date = '$date' AND (shift LIKE '%$op2%' OR shift LIKE '%$kp%')");
            $shift = 'SIANG';
        } else if ($time >= '20:30' && $time < '07:30') {
            $schedules = DB::select("SELECT employee_name, date, shift FROM doctors WHERE date = '$date' AND (shift LIKE '%$op3%')");
            $shift = 'MALAM';
        }

        // var_dump($schedules[0]->employee_name);

        // Driver
        $drivers = DB::select("select employee_name, date, shift from drivers WHERE date = '$date'");

        // var_dump($drivers);
        $specialties = [
            'Spesialis Anak' => [
                (object) ['photo' => 'av-1.svg', 'name' => 'dr. William Soeryaatmadja, Sp.PD, FPCP', 'qualification' => 'Sp.PD, FPCP'],
                (object) ['photo' => 'av-2.svg', 'name' => 'dr. Diyas Anugrah, Sp.A', 'qualification' => 'Sp.A'],
            ],
            'Spesialis Saraf' => [
                (object) ['photo' => 'av-3.svg', 'name' => 'dr. John Doe, Sp.S', 'qualification' => 'Sp.S'],
                (object) ['photo' => 'av-4.svg', 'name' => 'dr. Jane Doe, Sp.S', 'qualification' => 'Sp.S'],
            ],
            // Tambahkan data spesialis dan dokter lainnya di sini
        ];
        $doctors = [
            (object) ['specialty' => 'Spesialis Anak', 'photo' => 'av-1.svg', 'name' => 'dr. William Soeryaatmadja, Sp.PD, FPCP', 'qualification' => 'Sp.PD, FPCP'],
            (object) ['specialty' => 'Spesialis Saraf', 'photo' => 'av-2.svg', 'name' => 'dr. Diyas Anugrah, Sp.A', 'qualification' => 'Sp.A'],
            (object) ['specialty' => 'Spesialis Saraf', 'photo' => 'av-2.svg', 'name' => 'dr. Diyas Anugrah, Sp.A', 'qualification' => 'Sp.A'],
            (object) ['specialty' => 'Spesialis Saraf', 'photo' => 'av-2.svg', 'name' => 'dr. Diyas Anugrah, Sp.A', 'qualification' => 'Sp.A'],
            (object) ['specialty' => 'Spesialis Saraf', 'photo' => 'av-2.svg', 'name' => 'dr. Diyas Anugrah, Sp.A', 'qualification' => 'Sp.A'],
            (object) ['specialty' => 'Spesialis Saraf', 'photo' => 'av-2.svg', 'name' => 'dr. Diyas Anugrah, Sp.A', 'qualification' => 'Sp.A'],
            // Tambahkan data dokter lainnya di sini
        ];

        return view('schedules.plasma-aio', compact( 'schedules', 'drivers', 'shift', 'today', 'doctors'));
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
