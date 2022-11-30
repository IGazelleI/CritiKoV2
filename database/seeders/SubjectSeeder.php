<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            [
                'course_id' => 1,
                'code' => 'GEC-RPH',
                'descriptive_title' => 'Readings in Philippine History'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-MMW',
                'descriptive_title' => 'Mathematics in the Modern Word'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-TEM',
                'descriptive_title' => 'The Entrepreneurial Mind'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 111',
                'descriptive_title' => 'Introduction to Computing'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 112',
                'descriptive_title' => 'Programming 1 (Lec)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 112 L',
                'descriptive_title' => 'Programming 1 (Lab)'
            ],
            [
                'course_id' => 1,
                'code' => 'AP 1',
                'descriptive_title' => 'Multimedia'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-RPH',
                'descriptive_title' => 'Readings in Philippine History'
            ],
            [
                'course_id' => 1,
                'code' => 'PE 1',
                'descriptive_title' => 'Physical Education 1'
            ],
            [
                'course_id' => 1,
                'code' => 'NSTP 1',
                'descriptive_title' => 'National Service Training Program 1'
            ], //2nd sem 1st year
            [
                'course_id' => 1,
                'code' => 'GEC-PC',
                'descriptive_title' => 'Purposive Communication'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-STS',
                'descriptive_title' => 'Science, Technology and Society'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-US',
                'descriptive_title' => 'Understanding the Self'
            ],
            [
                'course_id' => 1,
                'code' => 'GEE-RRES',
                'descriptive_title' => 'Religions, Religious Experiences and Spirituality'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 123',
                'descriptive_title' => 'Programming 2 (Lec)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 123 L',
                'descriptive_title' => 'Programming 2 (Lab)'
            ],
            [
                'course_id' => 1,
                'code' => 'PC 121',
                'descriptive_title' => 'Discrete Mathematics'
            ],
            [
                'course_id' => 1,
                'code' => 'AP 2',
                'descriptive_title' => 'Digital Logic Design'
            ],
            [
                'course_id' => 1,
                'code' => 'PE 2',
                'descriptive_title' => 'Physical Education 2'
            ],
            [
                'course_id' => 1,
                'code' => 'NSTP 2',
                'descriptive_title' => 'National Service Training Program 2'
            ],//2nd year
            [
                'course_id' => 1,
                'code' => 'GEC-E',
                'descriptive_title' => 'Ethics'
            ],
            [
                'course_id' => 1,
                'code' => 'GEE-ES',
                'descriptive_title' => 'Environmental Science'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-LWR',
                'descriptive_title' => 'Life and Works of Rizal'
            ],
            [
                'course_id' => 1,
                'code' => 'PC 212',
                'descriptive_title' => 'Quantitative Methods (Modeling & Simulation)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 214',
                'descriptive_title' => 'Data Structures and Algorithms (Lec)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 214 L',
                'descriptive_title' => 'Data Structures and Algorithms (Lab)'
            ],
            [
                'course_id' => 1,
                'code' => 'P Elec 1',
                'descriptive_title' => 'Professional Elective 1'
            ],
            [
                'course_id' => 1,
                'code' => 'P Elec 2',
                'descriptive_title' => 'Professional Elective 2'
            ],
            [
                'course_id' => 1,
                'code' => 'PE 3',
                'descriptive_title' => 'Physical Education 3'
            ],//2nd sem 
            [
                'course_id' => 1,
                'code' => 'GEC-TCW',
                'descriptive_title' => 'The Contemporary World'
            ],
            [
                'course_id' => 1,
                'code' => 'PC 223',
                'descriptive_title' => 'Integrative Programming and Technologies 1'
            ],
            [
                'course_id' => 1,
                'code' => 'PC 224',
                'descriptive_title' => 'Networking 1'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 225',
                'descriptive_title' => 'Information Management (Lec)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 225 L',
                'descriptive_title' => 'Information Management (Lab)'
            ],
            [
                'course_id' => 1,
                'code' => 'P Elec 3',
                'descriptive_title' => 'Professional Elective 3'
            ],
            [
                'course_id' => 1,
                'code' => 'AP 3',
                'descriptive_title' => 'ASP.NET'
            ],
            [
                'course_id' => 1,
                'code' => 'PE 4',
                'descriptive_title' => 'Physical Education 4'
            ],//3rd year */
            [
                'course_id' => 1,
                'code' => 'GEC-KAF',
                'descriptive_title' => 'Komunikasyon sa Akademikong Filipino',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 315',
                'descriptive_title' => 'Networking 2 (Lec)',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 315 L',
                'descriptive_title' => 'Networking 2 (Lab)',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 316',
                'descriptive_title' => 'Systems Integration and Arcitecture 1',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 317',
                'descriptive_title' => 'Introduction to Human Computer Interaction',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 318',
                'descriptive_title' => 'Database Management Systems',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 319',
                'descriptive_title' => 'Applications Development and Emerging Technologies',
                'year_level' => 3,
                'semester' => 1
            ],//2nd sem
            [
                'course_id' => 1,
                'code' => 'GEC-AA',
                'descriptive_title' => 'Art Appreciation',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-PPTP',
                'descriptive_title' => 'Pagbasa at Pagsulat Tungo sa Pananaliksik',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'PC 329',
                'descriptive_title' => 'Capstone Project and Research 1 (Technopreneurship 1)',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'PC 3210',
                'descriptive_title' => 'Social and Professional Issues',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'PC 3211',
                'descriptive_title' => 'Information Assurance and Security 1 (Lec)',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'PC 3211 L',
                'descriptive_title' => 'Information Assurance and Security 1 (Lab)',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'AP 4',
                'descriptive_title' => 'iOS Mobile Application Development Cross-Platform',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'AP 5',
                'descriptive_title' => 'Technology and the Application of the Internet of Things',
                'year_level' => 3,
                'semester' => 2
            ],//4th year
            [
                'course_id' => 1,
                'code' => 'PC 4112',
                'descriptive_title' => 'Information and Assurance Security 2 (Lec)',
                'year_level' => 4,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 4112 L',
                'descriptive_title' => 'Information and Assurance Security 2 (Lab)',
                'year_level' => 4,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 4113',
                'descriptive_title' => 'Systems Administration and Maintenance',
                'year_level' => 4,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'P Elec 4',
                'descriptive_title' => 'Professional Elective 4',
                'year_level' => 4,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 4114',
                'descriptive_title' => 'Capstone Project and Research 2 (Technopreneurship 2)',
                'year_level' => 4,
                'semester' => 1
            ]
        ];

        foreach($subjects as $sub)
            Subject::create($sub);
    }
}
