<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'description' => 'College of Communication and Internet Computing Technology',
                'name' => 'CCICT'
            ],
            [
                'description' => 'College of Arts and Sciences',
                'name' => 'CAS'
            ],
            [
                'description' => 'College of Technology',
                'name' => 'CoT'
            ],
            [
                'description' => 'College of Engineering',
                'name' => 'CoE'
            ],
            [                    
                'description' => 'College of Education',
                'name' => 'CoEd'
            ]
        ];

        foreach($departments as $dept)
            Department::create($dept);
    }
}
