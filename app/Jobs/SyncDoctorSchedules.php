<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\MasterDokter;
use App\Models\ScheduleDokter;

class SyncDoctorSchedules implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // $response = Http::get('http://192.168.5.5/?mod=api&cmd=datadokter');
        $response = Http::withBasicAuth('rsciputra','rsciputra')->get('http://192.168.15.15/?mod=api&cmd=datadokter');
        // dd($response->json());

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $doctorData) {
                // Insert Data into master_dokters
                $doctor = MasterDokter::updateOrCreate(
                    ['id_tera' => $doctorData['doctor_id']],
                    [
                        'nama_dokter' => $doctorData['nama_doctor'],
                        'poli' => $doctorData['poli'],
                        'spesialis' => $doctorData['specialist'],
                    ]
                );

                // Insert Data into schedule_dokters
                foreach ($doctorData['schedule'] as $schedule) {
                    if ($schedule !== null) {
                        ScheduleDokter::updateOrCreate(
                            [
                                'doctor_id' => $doctor->id,
                                'weekday' => $schedule['weekday'],
                                'start_hour' => $schedule['start_hour'],
                                'start_minute' => $schedule['start_minute'],
                                'end_hour' => $schedule['end_hour'],
                                'end_minute' => $schedule['end_minute'],
                            ]
                        );
                    }
                }
            }
        }
    }
}
