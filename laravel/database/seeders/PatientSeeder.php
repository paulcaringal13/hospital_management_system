<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patients')->insert([
            [
                'id' => 1,
                'user_id' => 3, // Patient Account
                'gender' => 'Male', // You don't have gender data for this user
                'date_of_birth' => date('Y-m-d', strtotime('1997-01-02')), // You don't have date of birth data for this user
            ],
            [
                'id' => 2,
                'user_id' => 4, // Ethan Johnson
                'gender' => 'Male', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('1995-04-12')), // Sample date of birth
            ],
            [
                'id' => 3,
                'user_id' => 5, // Olivia Parker
                'gender' => 'Female', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('1982-02-11')), // Sample date of birth
            ],
            [
                'id' => 4,
                'user_id' => 6, // Liam Thompson
                'gender' => 'Male', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('1978-08-24')), // Sample date of birth
            ],
            [
                'id' => 5,
                'user_id' => 7, // Sophia Rodriguez
                'gender' => 'Female', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('1998-09-07')), // Sample date of birth
            ],
            [
                'id' => 6,
                'user_id' => 8, // Noah Martinez
                'gender' => 'Male', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('2000-03-15')), // Sample date of birth
            ],
            [
                'id' => 7,
                'user_id' => 9, // Emma Anderson
                'gender' => 'Female', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('1995-03-15')), // You don't have date of birth data for this user
            ],
            [
                'id' => 8,
                'user_id' => 10, // Charlotte Jones
                'gender' => 'Female', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('2005-03-15')), // You don't have date of birth data for this user
            ],
            [
                'id' => 9,
                'user_id' => 11, // Ava Williams
                'gender' => 'Female', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('2012-05-28')), // You don't have date of birth data for this user
            ],
            [
                'id' => 10,
                'user_id' => 12, // William Miller
                'gender' => 'Male', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('2013-12-30')), // You'd need actual date of birth data here
            ],
            [
                'id' => 11,
                'user_id' => 13, // Mia Brown
                'gender' => 'Female', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('1999-07-20')), // You'd need actual date of birth data here
            ],
            [
                'id' => 12,
                'user_id' => 24, // Michael Garcia
                'gender' => 'Male', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('2007-10-18')), // You'd need actual date of birth data here
            ],
            [
                'id' => 13,
                'user_id' => 25, // Isabella Hernandez
                'gender' => 'Female', // Assuming based on name
                'date_of_birth' => date('Y-m-d', strtotime('2008-12-25')), // You'd need actual date of birth data here
            ],
            [
                'id' => 14,
                'user_id' => 26, // James Moore
                'gender' => 'Male', // You don't have gender data for this user
                'date_of_birth' => date('Y-m-d', strtotime('1994-11-11')), // You don't have date of birth data for this user
            ],
        ]);
    }
}
