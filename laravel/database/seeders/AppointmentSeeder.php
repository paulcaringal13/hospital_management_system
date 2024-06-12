<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointments')->insert([
            'id' => 1,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-16 15:00:00',
            'status' => 'Booked',
        ]);

        DB::table('appointments')->insert([
            'id' => 2,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 15),
            'appointment_time' => '2024-06-14 20:00:00',
            'status' => 'Booked',
        ]);

        DB::table('appointments')->insert([
            'id' => 3,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-13 06:00:00',
            'status' => 'Booked',
        ]);

        DB::table('appointments')->insert([
            'id' => 4,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-17 13:00:00',
            'status' => 'Booked',
        ]);

        DB::table('appointments')->insert([
            'id' => 5,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-18 08:00:00',
            'status' => 'Booked',
        ]);



        DB::table('appointments')->insert([
            'id' => 6,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-17 14:00:00',
            'status' => 'Booked',
        ]);
        DB::table('appointments')->insert([
            'id' => 7,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-16 08:00:00',
            'status' => 'Booked',
        ]);
        DB::table('appointments')->insert([
            'id' => 8,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-15 10:00:00',
            'status' => 'Booked',
        ]);
        DB::table('appointments')->insert([
            'id' => 9,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-22 09:00:00',
            'status' => 'Booked',
        ]);
        DB::table('appointments')->insert([
            'id' => 10,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-21 06:00:00',
            'status' => 'Booked',
        ]);
        DB::table('appointments')->insert([
            'id' => 11,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-20 07:00:00',
            'status' => 'Booked',
        ]);
        DB::table('appointments')->insert([
            'id' => 12,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-26 09:00:00',
            'status' => 'Booked',
        ]);
        DB::table('appointments')->insert([
            'id' => 13,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-30 12:00:00',
            'status' => 'Booked',
        ]);
        DB::table('appointments')->insert([
            'id' => 14,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-21 11:00:00',
            'status' => 'Booked',
        ]);
    }
}