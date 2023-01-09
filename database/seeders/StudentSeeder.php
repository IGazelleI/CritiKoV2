<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = [
            [
                'type' => 4,
                'email' => 'clientvincent.amores@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 4,
                'email' => 'neofrank.uy@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 4,
                'email' => 'johnlloyd.cornejo@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 4,
                'email' => 'christinealissa.caintapan@ctu.edu.ph',
                'password' => bcrypt('amores15')
            ]
        ];

        $name = [
            [
                'id_number' => 1190435,
                'fname' => 'Client Vincent',
                'lname' => 'Amores'
            ],
            [
                'id_number' => 1190436,
                'fname' => 'Neo Frank',
                'lname' => 'Uyy'
            ],
            [
                'id_number' => 1190437,
                'fname' => 'John Lloyd',
                'lname' => 'Cornejo'
            ],
            [
                'id_number' => 1190438,
                'fname' => 'Christine Alissa',
                'lname' => 'Caintapan'
            ]
        ];
        
        $i = 0;

        foreach($students as $det)
        {
            $user = User::factory()->create($det);

            Student::create([
                'id_number' => $name[$i]['id_number'],
                'fname' => $name[$i]['fname'],
                'lname' => $name[$i]['lname'],
                'user_id' => $user->id
            ]);

            $i += 1;
        }
    }
}
