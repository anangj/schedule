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

        $categories = [
            'slide 1' => ['SPESIALIS PENYAKIT DALAM KONSULTAN GINJAL DAN HIPERTENSI',
                'SPESIALIS PENYAKIT DALAM KONSULTAN GASTRO ENTRO HEPATOLOGI',
                'SPESIALIS PENYAKIT DALAM',
                'SPESIALIS JANTUNG DAN PEMBULUH DARAH',
                'SPESIALIS PARU',
                'SPESIALIS ANAK',
                'SPESIALIS THT'],
            'slide 2' => ['SPESIALIS BEDAH UROLOGI',
                'SPESIALIS BEDAH UMUM',
                'SPESIALIS BEDAH ORTHOPEDI DAN TRAUMATOLOGI',
                'SPESIALIS BEDAH ORTHOPEDI DAN TRAUMATOLOGI KONSULTAN HIP DAN KNEE',
                'SPESIALIS BEDAH KONSULTAN BEDAH DIGESTIF',
                'SPESIALIS BEDAH TORAKS DAN KARDIOVASKULAR',
                'SPESIALIS BEDAH SYARAF',
                'SPESIALIS BEDAH PLASTIK'],
            'slide 3' => ['SPESIALIS MATA',
                'SPESIALIS AKUPUNTUR',
                'SPESIALIS SARAF',
                'SPESIALIS KEBIDANAN DAN KANDUNGAN',
                'SPESIALIS KULIT DAN KELAMIN',
                'SPESIALIS ANASTESI',
                'SPESIALIS ANASTESI KONSULTAN INTENSIF CARE',
                'SPESIALIS ANASTESI KONSULTAN KARDIOVASKULAR']
        ];
        
        // Create a new query with the category column
        $subQuery = DB::table('doctor_specialists as ds')
            ->select(
                'md.id_tera',
                'ds.speciality_name',
                'ds.employee_name',
                'ds.date',
                'ds.shift',
                'md.image_url',
                DB::raw('ROW_NUMBER() OVER (PARTITION BY ds.speciality_name ORDER BY ds.shift) as row_num'),
                DB::raw("
                    CASE 
                        " . implode(" ", array_map(function($category, $specialities) {
                            return "WHEN ds.speciality_name IN ('" . implode("','", $specialities) . "') THEN '{$category}'";
                        }, array_keys($categories), $categories)) . "
                        ELSE 'Other'
                    END as category
                ")
            )
            ->rightJoin('master_dokters as md', 'md.id_tera', '=', 'ds.employee_id')
            ->where('ds.date', $date)
            ->where('ds.shift', 'not like', $shiftCondition);
        
        // Main Query
        $schedules = DB::table(DB::raw("({$subQuery->toSql()}) as ranked_doctors"))
            ->mergeBindings($subQuery) // Bind the parameters from the subquery
            ->select(
                'category',
                'speciality_name',
                DB::raw('GROUP_CONCAT(employee_name SEPARATOR "||") as doctors'),
                DB::raw('GROUP_CONCAT(image_url SEPARATOR "||") as image_url')
            )
            ->where('row_num', '<=', 2)
            ->groupBy('category', 'speciality_name')
            ->orderBy('category')
            ->orderBy('speciality_name')
            ->get();
        
        $schedules = $schedules->map(function ($item) {
            $item->doctors = explode('||', $item->doctors);
            $item->image_url = explode('||', $item->image_url);
            return $item;
        });
        /// end spesialis

        /// petugas igd
        $kp = 'KP'; // dari jam 7-16
        $op1 = 'OP-1';
        $op2 = 'OP-2';
        $op3 = 'OP-3';
        $p = 'P';
        $s = 'S';
        $m = 'M';
        $ps = 'PS';
        $pj1 = 'OP-1-pj';
        $pj2 = 'OP-2-pj';
        $pj3 = 'OP-2-pj';
        $ls1 = 'OP-1-ls';
        $ls2 = 'OP-2-ls';
        $ls3 = 'OP-3-ls';
        $office = 'office';
        $middle3 = 'middle-3';
        $shift = '';
        $today = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $doctors = [];
        $nurses = [];
        $drivers = [];
        $nod = [];
        // $kp = [];

        // Query for doctors office
        if ($time >= '08:00' && $time <= '17:00') {
            $doctorOffice = DB::select("SELECT md.id_tera, d.employee_name , d.`date` , d.shift , md.image_url  from doctors d left join master_dokters md on d.employee_id = md.id_tera WHERE date = '$date' AND md.id_tera = '-1639' ");
        }

        // Doctors
        if ($time >= '07:00' && $time < '13:28') {
            $doctors = DB::select("SELECT d.employee_name , d.`date` , d.shift , md.image_url  from doctors d left join master_dokters md on d.employee_id = md.id_tera WHERE date = '$date' AND (shift LIKE '%$p%' OR shift LIKE '%$kp%' OR shift = '$ps')");
            $shift = 'PAGI';
        } else if ($time >= '13:30' && $time < '20:58') {
            $doctors = DB::select("SELECT d.employee_name , d.`date` , d.shift , md.image_url  from doctors d left join master_dokters md on d.employee_id = md.id_tera WHERE date = '$date' AND (shift LIKE '%$s%' OR shift = '$ps')");
            $shift = 'SIANG';
        } else if ($time >= '21:00') {
            $doctors = DB::select("SELECT d.employee_name , d.`date` , d.shift , md.image_url  from doctors d left join master_dokters md on d.employee_id = md.id_tera WHERE date = '$date' AND (shift LIKE '%$m%')");
            $shift = 'MALAM';
        }

        if ($time >= '08:00' && $time <= '17:00') {
            $mergedDoctors = array_merge($doctorOffice,$doctors);
        } else {
            $mergedDoctors = $doctors;
        }

        // NOD
        if ($time >= '07:00' && $time < '13:28') {
            $nod = DB::select("SELECT n.employee_name, n.date, n.shift , mn.image_url FROM nods n left join master_nods mn on n.employee_id = mn.employee_id  WHERE date = '$date' AND shift like '%$op1%'");
            $shift = 'PAGI';
        } else if ($time >= '13:30' && $time < '20:58') {
            $nod = DB::select("SELECT n.employee_name, n.date, n.shift , mn.image_url FROM nods n left join master_nods mn on n.employee_id = mn.employee_id  WHERE date = '$date' AND shift like '%$op2%'");
            $shift = 'SIANG';
        } else if ($time >= '21:00') {
            $nod = DB::select("SELECT n.employee_name, n.date, n.shift , mn.image_url FROM nods n left join master_nods mn on n.employee_id = mn.employee_id  WHERE date = '$date' AND (shift LIKE '%$op3%' OR shift LIKE '%$middle3%')");
            $shift = 'MALAM';
        }

        // QUERY FOR KP
        if ($time >= '07:00' && $time <= '16:00') {
            $kp = DB::select("SELECT n.employee_name , n.date, n.shift ,mn.image_url  from nurses n left join master_nurses mn on n.employee_id = mn.employee_id WHERE date = '$date' AND shift = '$kp' group by n.id ");
        }

        // Nurses
        if ($time >= '07:00' && $time < '13:28') {
            $nurses = DB::select("SELECT n.employee_name , n.date, n.shift ,mn.image_url  from nurses n left join master_nurses mn on n.employee_id = mn.employee_id WHERE date = '$date' AND shift like '%$op1%' group by n.id");
            $shift = 'PAGI';
        } else if ($time >= '13:30' && $time < '20:58') {
            $nurses = DB::select("SELECT n.employee_name , n.date, n.shift ,mn.image_url  from nurses n left join master_nurses mn on n.employee_id = mn.employee_id WHERE date = '$date' AND shift like '%$op2%' group by n.id");
            $shift = 'SIANG';
        } else if ($time >= '21:00') {
            $nurses = DB::select("SELECT n.employee_name , n.date, n.shift ,mn.image_url  from nurses n left join master_nurses mn on n.employee_id = mn.employee_id WHERE date = '$date' AND (shift LIKE '%$op3%' OR shift LIKE '%$middle3%') group by n.id");
            $shift = 'MALAM';
        }


        if ($time >= '07:00' && $time <= '16:00') {
            $merged = array_merge($kp,$nurses);
        } else {
            $merged = $nurses;
        }




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

        // // Combine doctors, nurses, and drivers into one collection
        
        $doctors = collect($mergedDoctors)->map(function ($doctor) {
            return ['type' => 'doctor', 'data' => $doctor, 'title' => 'DOCTOR'];
        });
        
        $nods = collect($nod)->map(function ($nod) {
            return ['type' => 'nod', 'data' => $nod, 'title' => 'NOD'];
        });
        
        $nurses = collect($merged)->map(function ($nurse) {
            return ['type' => 'nurse', 'data' => $nurse, 'title' => 'NURSE'];
        });
        
        $drivers = collect($drivers)->map(function ($driver) {
            return ['type' => 'driver', 'data' => $driver, 'title' => 'DRIVER'];
        });
        
        $columns = [[], [], [], []]; // Initialize four columns
        
        // Add doctors and NODs to the first column
        foreach ($doctors as $doctor) {
            $columns[0][] = $doctor;
        }
        foreach ($nods as $nod) {
            $columns[0][] = $nod;
        }
        
        // Add nurses to the second column, handle overflow into the third column if needed
        $currentColumn = 1; // Start from the second column for nurses
        foreach ($nurses as $nurse) {
            $columns[1][] = $nurse;
        }
        
        // If there is overflow in the second column (more than 5 nurses), move the overflow to the third column
        if (count($columns[1]) > 4) {
            $overflowNurses = array_splice($columns[1], 4); // Get the overflow nurses
            $columns[2] = array_merge($columns[2], $overflowNurses); // Add overflow nurses to the third column
        }
        
        // Add drivers to the third column if the second column has no overflow, otherwise to the fourth column
        $driverColumn = count($columns[2]) > 0 ? 3 : 2;
        foreach ($drivers as $driver) {
            $columns[$driverColumn][] = $driver;
        }
        
        return view('plasma.plasma', compact('schedules', 'columns', 'shift', 'today'));
        

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
