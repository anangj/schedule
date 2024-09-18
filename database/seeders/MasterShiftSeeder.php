<?php

namespace Database\Seeders;

use App\Models\MasterShift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $shifts = [
            [
                'name_shift' => 'Office',
                'code_shift' => 'Office',
                'start_time' => '08:00',
                'end_time'   => '17:00'
            ],
            [
                'name_shift' => 'OP-1',
                'code_shift' => 'OP-1',
                'start_time' => '07:00',
                'end_time'   => '13:30'
            ],
            [
                'name_shift' => 'OP-2',
                'code_shift' => 'OP-2',
                'start_time' => '13:30',
                'end_time'   => '21:00'
            ],
            [
                'name_shift' => 'OP-3',
                'code_shift' => 'OP-3',
                'start_time' => '21:00',
                'end_time'   => '07:00'
            ],
            [
                'name_shift' => 'KP-Khusus',
                'code_shift' => 'kp-khsusu',
                'start_time' => '07:00',
                'end_time'   => '16:00'
            ],
            [
                'name_shift' => 'OP-1-long shift',
                'code_shift' => 'OP-1-LS',
                'start_time' => '07:00',
                'end_time'   => '21:00'
            ],
            [
                'name_shift' => 'OP-2-long shift',
                'code_shift' => 'OP-2-LS',
                'start_time' => '13:30',
                'end_time'   => '07:00'
            ],
            [
                'name_shift' => 'OP-3-long shift',
                'code_shift' => 'OP-3-LS',
                'start_time' => '21:00',
                'end_time'   => '13:30'
            ],
            [
                'name_shift' => 'OP-1-PJ',
                'code_shift' => 'OP-1-PJ',
                'start_time' => '07:00',
                'end_time'   => '13:30'
            ],
            [
                'name_shift' => 'OP-2-PJ',
                'code_shift' => 'OP-2-PJ',
                'start_time' => '13:30',
                'end_time'   => '21:00'
            ],
            [
                'name_shift' => 'OP-3-PJ',
                'code_shift' => 'OP-3-PJ',
                'start_time' => '21:00',
                'end_time'   => '07:00'
            ],
            [
                'name_shift' => 'Dayoff',
                'code_shift' => 'Dayoff',
                'start_time' => '',
                'end_time'   => ''
            ],
        ];
        foreach ($shifts as $key => $value) {
            $shift = MasterShift::create($value);
        }
    }
}
