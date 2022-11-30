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
                'name' => 'Jose Marie Garcia', */
                'email' => 'jose@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Bell Campanilla', */
                'email' => 'bell@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Pet Andrew Nacua', */
                'email' => 'pet@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Noreen Fuentes', */
                'email' => 'noreen@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Dindo Logpit', */
                'email' => 'dindo@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Starzy Bicare Baluarte-Bacus', */
                'email' => 'starzy@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,/* 
                'name' => 'Joey Sayson', */
                'email' => 'joey@gmail.com',
                'password' => bcrypt('amores15')
            ]
        ]; 

        foreach($faculty as $facs)
        {
            $user = User::factory()->create($facs);

            if($user->type == 'faculty')
            {
                Faculty::factory()->create([
                    'user_id' => $user->id,
                    'department_id' => 1
                ]);
            }
        }
    }
}
