<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doctors')->insert([
            [
                'id' => 1,
                'user_id' => 2, // Dr. David Walker
                'specialization' => 'Orthopedics', // Sample specialization
            ],
            [
                'id' => 2,
                'user_id' => 15, // Dr. William Miller
                'specialization' => 'Dermatology', // Sample specialization
            ],
            [
                'id' => 3,
                'user_id' => 16, // Dr. Mia Garcia
                'specialization' => 'Pediatrics', // Sample specialization
            ],
            [
                'id' => 4,
                'user_id' => 17, // Dr. Michael Brown
                'specialization' => 'Orthopedics', // Sample specialization
            ],
            [
                'id' => 5,
                'user_id' => 18, // Dr. Isabella Hernandez
                'specialization' => 'Neurology', // Sample specialization
            ],
            [
                'id' => 6,
                'user_id' => 19, // Dr. James Moore
                'specialization' => 'Gastroenterology', // Sample specialization
            ],
            [
                'id' => 7,
                'user_id' => 20, // Dr. Emily Lopez
                'specialization' => 'Pulmonology', // Sample specialization
            ],
            [
                'id' => 8,
                'user_id' => 21, // Dr. Benjamin Lewis
                'specialization' => 'Ophthalmology', // Sample specialization
            ],
            [
                'id' => 9,
                'user_id' => 22, // Dr. Ashley Robinson
                'specialization' => 'Psychiatry', // Sample specialization
            ],
            [
                'id' => 10,
                'user_id' => 23, // Dr. David Walker
                'specialization' => 'Obstetrics & Gynecology', // Sample specialization
            ],
            [
                'id' => 11,
                'user_id' => 14, // Dr. Olivia Jones
                'specialization' => 'Cardiology', // Sample specialization
            ],
        ]);
    }
}

