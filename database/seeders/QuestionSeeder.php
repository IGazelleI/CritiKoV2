<?php

namespace Database\Seeders;

use App\Models\QType;
use App\Models\Question;
use App\Models\QCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Factory question types
        $qtype = [
            [
                'name' => 'Quantitative'
            ],
            [
                'name' => 'Qualitative'
            ]
        ];
        foreach($qtype as $type)
            QType::create($type);

        $qcat = [
            [
                'type' => 3,
                'name' => 'Teacher'
            ],
            [
                'type' => 3,
                'name' => 'Students'
            ],
            [
                'type' => 3,
                'name' => 'Learning Environment'
            ],
            [
                'type' => 4,
                'name' => 'Management'
            ],
            [
                'type' => 4,
                'name' => 'Performance'
            ]
        ];

        foreach($qcat as $cat)
            QCategory::create($cat);

        //faculty
        //lab questions
        $facultyLabQuestions = [
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'isLec' => false,
                'sentence' => 'laboratory planning and organizing skills',
                'keyword' => 'organized'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'isLec' => false,
                'sentence' => 'ability to conduct laboratory classes logically and systematically',
                'keyword' => 'logical and systematic'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'isLec' => false,
                'sentence' => 'initiative and common sense',
                'keyword' => 'initiative'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'isLec' => false,
                'sentence' => 'resourcefulness',
                'keyword' => 'resourceful'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'isLec' => false,
                'sentence' => 'ability to motivate students participation',
                'keyword' => 'organized'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'isLec' => false,
                'sentence' => 'ability to motivate students for critical thinking and independent study during laboratory classes',
                'keyword' => 'improve students critical thinking'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'isLec' => false,
                'sentence' => 'ability to motive students participation',
                'keyword' => 'organized'
            ],//2nd category
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'isLec' => false,
                'sentence' => 'student-teacher interaction',
                'keyword' => 'interaction with student'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'isLec' => false,
                'sentence' => 'preparedness for laboratory work',
                'keyword' => 'preparedness'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'isLec' => false,
                'sentence' => 'communication skills',
                'keyword' => 'communication skills'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'isLec' => false,
                'sentence' => 'interest',
                'keyword' => 'interest'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'isLec' => false,
                'sentence' => 'awareness of new concepts',
                'keyword' => 'new concept awareness'
            ], //3rd category
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'isLec' => false,
                'sentence' => 'availability and accessibility of equipment, supplies and materials',
                'keyword' => 'availability'
            ], 
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'isLec' => false,
                'sentence' => 'arrangement of equipment/furniture in the laboratory',
                'keyword' => 'arrange equipments in laboratory'
            ], 
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'isLec' => false,
                'sentence' => 'safety conditions',
                'keyword' => 'promotes safety'
            ], 
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'isLec' => false,
                'sentence' => 'lighting and ventilation',
                'keyword' => 'lighting and ventilation'
            ], 
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'isLec' => false,
                'sentence' => 'water supply',
                'keyword' => 'water supply'
            ], 
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'isLec' => false,
                'sentence' => 'housekeeping (orderliness & cleanliness)',
                'keyword' => 'orderliness & cleanliness'
            ], 
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'isLec' => false,
                'sentence' => 'Student-teacher interaction',
                'keyword' => 'interaction with student'
            ], //qualitative questions
            [
                'q_type_id' => 2,
                'isLec' => false,
                'sentence' => 'strong points',
            ],
            [
                'q_type_id' => 2,
                'isLec' => false,
                'sentence' => 'further improvements',
            ],
            [
                'q_type_id' => 2,
                'isLec' => false,
                'sentence' => 'suggestions',
            ]
        ];

        foreach($facultyLabQuestions as $q)
            Question::create($q);

        //student questions
        $studentQuestions = [
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'gives reasonable course/subject assignments',
                'keyword' => 'reasonable'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'earns appreciation and kind attention from the students',
                'keyword' => 'appreciative'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'gives orientation about the subject and how the students are evaluated',
                'keyword' => 'briefs subject'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'gives test and/or projects which are within the objectives of the course',
                'keyword' => 'test/projects given was discussed'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'shows concern in assisting the students',
                'keyword' => 'helps students'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'shows sympathetic insight into students’ feelings',
                'keyword' => 'sympathetic'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'checks and records test papers/term papers promptly',
                'keyword' => 'dili tingubon check'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'is on time and regular in meeting the class',
                'keyword' => 'punctual'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'assigns fair subject/course requirements',
                'keyword' => 'fair subject/course requirements'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'sustains the attention of the class for the whole period',
                'keyword' => 'class is listening'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'presents lesson clearly, methodically, and substantially',
                'keyword' => 'clear presentation of lessons'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'motivates the students to learn',
                'keyword' => 'motivator'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'facilitates learning with the application of appropriate educational methods and techniques',
                'keyword' => 'teaching strategy'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'shows mastery of the lesson',
                'keyword' => 'mastery of lesson'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'is prepared for the class',
                'keyword' => 'prepared'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'inspires students’ self-reliance in their quest for knowledge',
                'keyword' => 'make students eager to learn'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'knows when the students have difficulty understanding the lesson and finds ways to make it easy',
                'keyword' => 'knows the limit of students understanding'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'integrates values into the lesson',
                'keyword' => 'values oriented'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'Speaks the language of instruction (English or Filipino) clearly and fluently',
                'keyword' => 'speaks language being used clearly'
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'delivers thought provoking questions',
                'keyword' => 'makes student think more'
            ],
            [
                'q_type_id' => 2,
                'q_category_id' => 5,
                'sentence' => 'Comments/Suggestions'
            ]
        ];
        foreach($studentQuestions as $q)
            Question::create($q);
    }
}
