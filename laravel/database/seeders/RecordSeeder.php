<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remarks array
        $remarks = [
            "Everything looks good. Remember to take your medication as prescribed.",
            "I'm pleased with your progress. Keep up the good work!",
            "Your test results came back normal. No cause for concern.",
            "Let's schedule a follow-up appointment to discuss your treatment plan further.",
            "It's important to maintain a healthy lifestyle to support your recovery.",
            "If you experience any unusual symptoms, don't hesitate to contact me immediately.",
            "We'll adjust your medication dosage slightly to better manage your symptoms.",
            "I recommend some lifestyle changes to improve your overall health.",
            "Your condition requires further evaluation. We'll schedule additional tests.",
            "I'm concerned about your recent symptoms. Let's discuss them in detail.",
        ];

        // Insert records
        DB::table('records')->insert([
            'id' => 1,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-05-18 08:00:00',
            'status' => 'Finished',
            'remarks' => $remarks[array_rand($remarks)],
        ]);

        DB::table('records')->insert([
            'id' => 2,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-18 08:00:00',
            'status' => 'Finished',
            'remarks' => $remarks[array_rand($remarks)],
        ]);

        DB::table('records')->insert([
            'id' => 3,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-18 09:00:00',
            'status' => 'Finished',
            'remarks' => $remarks[array_rand($remarks)],
        ]);


        DB::table('records')->insert([
            'id' => 4,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-05-20 11:00:00',
            'status' => 'Finished',
            'remarks' => $remarks[array_rand($remarks)],
        ]);

        DB::table('records')->insert([
            'id' => 5,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-04-18 12:00:00',
            'status' => 'Finished',
            'remarks' => $remarks[array_rand($remarks)],
        ]);

        DB::table('records')->insert([
            'id' => 6,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-05-26 08:00:00',
            'status' => 'Finished',
            'remarks' => $remarks[array_rand($remarks)],
        ]);

        DB::table('records')->insert([
            'id' => 7,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-05-21 20:00:00',
            'status' => 'Finished',
            'remarks' => $remarks[array_rand($remarks)],
        ]);

        DB::table('records')->insert([
            'id' => 8,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-06-05 22:00:00',
            'status' => 'Finished',
            'remarks' => $remarks[array_rand($remarks)],
        ]);

        DB::table('records')->insert([
            'id' => 9,
            'doctor_id' => rand(1, 10),
            'patient_id' => rand(1, 14),
            'appointment_time' => '2024-04-30 07:00:00',
            'status' => 'Finished',
            'remarks' => $remarks[array_rand($remarks)],
        ]);
    }
}