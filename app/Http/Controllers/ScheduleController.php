<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Http\Resources\ScheduleCollection;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ScheduleImport;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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
        // PAGI = 07:00 - 14:30
        // SIANG = 13:30 - 21:00 
        // MALAM = 20:30 - 07:30

        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
        $kp = '%K-P%';
        $op1 = 'OP-1';
        $op2 = 'OP-2';
        $op3 = 'OP-3';


        // $schedules = Schedule::all();
        // $schedules = Schedule::where('date', $date)
        //     ->where(function ($query) {
        //         $query->where('shift', 'like', '%OP-1%')
        //             ->orWhere('shift', 'like', '%K-P%');
        //     })
        //     ->get();

        if ($time >= '07:00' && $time < '14:30') {
            $schedules = DB::select("SELECT * FROM schedules WHERE date = '$date' AND (shift LIKE '%$op1%' OR shift LIKE '%$kp%')");
        } else if ($time >= '13:30' && $time < '21:00') {
            $schedules = DB::select("SELECT * FROM schedules WHERE date = '$date' AND (shift LIKE '%$op2%' OR shift LIKE '%$kp%')");
        } else if ($time >= '20:30' && $time < '07:30') {
            $schedules = DB::select("SELECT * FROM schedules WHERE date = '$date' AND (shift LIKE '%$op3%')");
        }

        

        // $schedules = DB::select("SELECT * FROM schedules WHERE date = '$date' AND (shift LIKE '%OP-1%' OR shift LIKE '%K-P%')");
        // var_dump(count($schedules));
        return view('plasma.plasma', ['schedules' => $schedules]);
    }

    public function plasmaSpecialist()
    {
        $schedules = Schedule::all();
        return view('plasma.plasma-specialist', ['schedules' => $schedules]);
    }

    public function create()
    {
        return view('schedules.create');
    }

    public function storeExcel(Request $request)
    {
        // Mengasumsikan file telah diunggah melalui form
        $file = $request->file('excel_file');

        // Memuat file
        $rows = Excel::toArray([], $file);

        // Mendapatkan nomor baris header
        $headerRowNumber = $this->getHeaderRowNumber($rows);

        // Mendapatkan header
        $headers = $rows[0][$headerRowNumber];

        // Melakukan iterasi melalui baris data
        for ($i = $headerRowNumber + 1; $i < count($rows[0]); $i++) {
            // Mengakses data setiap baris
            $rowData = $rows[0][$i];

            // Contoh cara mengakses data
            $employeeId = $rowData[0]; // Diasumsikan ID Karyawan adalah kolom pertama
            $employeeName = $rowData[1]; // Diasumsikan Nama Karyawan adalah kolom kedua

            // Menangani data secara dinamis berdasarkan header
            for ($j = 2; $j < count($headers); $j++) {
                // var_dump($employeeId);
                $date = $headers[$j]; // Diasumsikan kolom tanggal dimulai dari kolom ketiga
                $attendance = $rowData[$j]; // Data kehadiran untuk tanggal tersebut

                // Memproses data Anda di sini
                $schedules = new Schedule();
                $schedules->employee_id = $employeeId;
                $schedules->employee_name = $employeeName;
                $schedules->date = $date;
                $schedules->shift = $attendance;
                $schedules->save();
            }
        }
    }

    private function getHeaderRowNumber($rows)
    {
        // Melakukan iterasi melalui baris untuk menemukan baris header
        foreach ($rows[0] as $key => $row) {
            // Diasumsikan baris header mengandung "Employee ID" atau kata kunci unik lainnya
            if (in_array('Employee ID', $row)) {
                return $key;
            }
        }
        return null; // Menangani jika baris header tidak ditemukan
    }

    // public function storeExcel(Request $request)
    // {

    //     if ($request->hasFile('excel_file')) {
    //         $path = $request->file('excel_file')->getRealPath();
    //         Excel::import(new ScheduleImport, $path);

    //         return back()->with('success', 'Data Jadwal telah berhasil diunggah.');
    //     } else {
    //         return back()->with('error', 'File Excel tidak ditemukan.');
    //     }
    //     // if ($request->hasFile('excel_file')) {
    //     //     $path = $request->file('excel_file')->getRealPath();
    //     //     $data = Excel::toArray(new ScheduleImport, $path);
    //     //     var_dump($data);

    //         // Proses data yang didapat dari file Excel
    //         // foreach ($data as $key => $value) {
    //         //     foreach ($value as $row) {
    //         //         // Contoh: Membuat atau memperbarui jadwal berdasarkan data Excel
    //         //         Schedule::updateOrCreate(
    //         //             ['id' => $row['id']],
    //         //             [
    //         //                 'name' => $row['name'],
    //         //                 'start_time' => $row['start_time'],
    //         //                 'end_time' => $row['end_time'],
    //         //                 'description' => $row['description']
    //         //             ]
    //         //         );
    //         //     }
    //         // }
    //     // } else {
    //     //     return back()->with('error', 'File Excel tidak ditemukan.');
    //     // }

    //     // return back()->with('success', 'Data Jadwal telah berhasil diunggah.');
    // }
}
