<?php

namespace Database\Seeders;

use App\Models\Sast;
use App\Models\User;
use App\Models\Admin;
use App\Models\Period;
use App\Models\AcademicYear;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::factory()->create([
            'type' => 1,
            'email' => 'admin@ctu.edu.ph',
            'password' => bcrypt('amores15')
        ]);

        Admin::create([
            'user_id' => $admin->id
        ]);

        $sast = User::factory()->create([
            'type' => 2,
            'email' => 'sast@ctu.edu.ph',
            'password' => bcrypt('amores15')
        ]);

        Sast::create([
            'user_id' => $sast->id
        ]);

        $acad = AcademicYear::create([
            'begin' => '2022',
            'end' => '2023'
        ]);

        Period::create([
            'academic_year_id' => $acad->id,
            'semester' => 1,
            'begin' => NOW(),
            'end' => NOW()->addMonths(6)
        ]);
    }
}
