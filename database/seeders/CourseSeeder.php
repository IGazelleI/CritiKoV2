<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            [
                'department_id' => 1,
                'description' => 'Bachelor of Science in Information Technology',
                'name' => 'BSIT'
            ],
            [
                'department_id' => 1,
                'description' => 'Bachelor of Science in Computer Science',
                'name' => 'BSCS'
            ],
            [
                'department_id' => 1,
                'description' => 'Bachelor of Science in Computer Technology',
                'name' => 'BSCompTech'
            ],
            [
                'department_id' => 1,
                'description' => 'Bachelor of Science in Information System',
                'name' => 'BSIS'
            ]
        ];

        foreach($courses as $c)
            Course::create($c);

    }
}
