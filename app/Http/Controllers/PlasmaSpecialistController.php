<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\DoctorSpecialist;

class PlasmaSpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $date = Carbon::now()->format('Y-m-d');
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
            ->groupBy('speciality_name', 'shift')
            ->get();

        $schedules = $schedules->map(function ($item) {
            $item->doctors = explode('||', $item->doctors);
            return $item;
        });

        // dd($today);

        // dd($schedules);
        return view('plasma.plasma-specialist', compact('schedules', 'shift', 'today'));
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
