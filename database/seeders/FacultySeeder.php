<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Faculty;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculty = [
            [
                'type' => 3,/* 
                'name' => 'Jose Maria Garcia', */
                'email' => 'josemaria.garcia@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Bell Campanilla', */
                'email' => 'bell.campanilla@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Pet Andrew Nacua', */
                'email' => 'petandrew.nacua@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Noreen Fuentes', */
                'email' => 'noreen.fuentes@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Dindo Logpit', */
                'email' => 'dindo.logpit@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Starzy Bicare Baluarte-Bacus', */
                'email' => 'suzette.bacus@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Joey Sayson', */
                'email' => 'joey.sayson@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ]
        ];

        $name = [
            [
                'fname' => 'Jose Maria',
                'lname' => 'Garcia'
            ],
            [
                'fname' => 'Bell',
                'lname' => 'Campanilla'
            ],
            [
                'fname' => 'Pet Andrew',
                'lname' => 'Nacua'
            ],
            [
                'fname' => 'Noreen',
                'lname' => 'Fuentes'
            ],
            [
                'fname' => 'Dindo',
                'lname' => 'Logpit'
            ],
            [
                'fname' => 'Suzette Bicare',
                'lname' => 'Baluarte-Bacus'
            ],
            [
                'fname' => 'Joey',
                'lname' => 'Sayson'
            ],
            [
                'fname' => 'Cherry',
                'lname' => 'Minguito'
            ]
        ];

        $i = 0;

        foreach($faculty as $facs)
        {
            $user = User::factory()->create($facs);

            Faculty::create([
                'user_id' => $user->id,
                'fname' => $name[$i]['fname'],
                'lname' => $name[$i]['lname'],
                'department_id' => 1
            ]);
            $i += 1;
        }
    }
}
