<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $position = [
            [
                'position_name' => 'IGD',
                'floor' => 'igd',
                'isActive' => 1
            ],
            [
                'position_name' => 'Lobby',
                'floor' => 'lobby',
                'isActive' => 1
            ]
        ];

        DB::table('event_positions')->insert($position);
    }
}
