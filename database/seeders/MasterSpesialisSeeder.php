<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSpesialisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spesialis= [
            [
                'name' => 'Anak'
            ],
            [
                'name' => 'Penyakit Dalam'
            ],
            [
                'name' => 'Jantung dan Pembuluh Darah'
            ],
            [
                'name' => 'Paru'
            ],
            [
                'name' => 'Saraf'
            ],
            [
                'name' => 'Kebidanan dan Kandungan'
            ],
            [
                'name' => 'Kandungan dan Kebudanan (Unit Fertility)'
            ],
            [
                'name' => 'Bedah Umum'
            ],
            [
                'name' => 'Bedah Orthopedi dan Traumatologi'
            ],
            [
                'name' => 'Bedah Urologi'
            ],
            [
                'name' => 'Bedah Saraf'
            ],
            [
                'name' => 'Bedah Toraks dan Kardiovaskular'
            ],
            [
                'name' => 'Bedah Plastik Rekontruksi dan Estetika'
            ],
            [
                'name' => 'Mata'
            ],
            [
                'name' => 'THT'
            ],
            [
                'name' => 'Gizi Klinik'
            ],
            [
                'name' => 'Kedokteran Jiwa'
            ],
            [
                'name' => 'Kedokteran Okupasi'
            ],
            [
                'name' => 'Kulit dan Kelamin'
            ],
            [
                'name' => 'Rehabilitasi Medik'
            ],
            [
                'name' => 'Bedah Digestif'
            ],
            [
                'name' => 'Radiologi'
            ],
            [
                'name' => 'Psikolog Klinis'
            ],
            [
                'name' => 'Anastesi'
            ],
            [
                'name' => 'Patologi Klinik'
            ],
            [
                'name' => 'Patologi Anatomi'
            ],
            [
                'name' => 'Mikrobiologi Klinik'
            ],
            [
                'name' => 'Akupuntur'
            ],
        ];

        DB::table('master_spesialis')->insert($spesialis);
    }
}
