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
                'name' => 'Management'
            ],
            [
                'name' => 'Performance'
            ],
            [
                'name' => 'Behaviour'
            ],
            [
                'name' => 'Support'
            ],
            [
                'name' => 'Personality'
            ]
        ];
        $cats = [];
        $i = 0;

        foreach($qcat as $cat)
        {
            $cats[$i] = QCategory::create($cat);
            $i++;
        }
        //factory management questions
        $questions = [
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'sentence' => 'gives reasonable course/subject assignments',
                'keyword' => 'reasonable',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'sentence' => 'earns appreciation and kind attention from the students',
                'keyword' => 'appreciative',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'sentence' => 'gives orientation about the subject and how the students are evaluated',
                'keyword' => 'briefs subject',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'sentence' => 'gives test and/or projects which are within the objectives of the course',
                'keyword' => 'test/projects given was discussed',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'sentence' => 'shows concern in assisting the students',
                'keyword' => 'helps students',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'sentence' => 'shows sympathetic insight into students’ feelings',
                'keyword' => 'sympathetic',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'sentence' => 'checks and records test papers/term papers promptly',
                'keyword' => 'dili tingubon check',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'sentence' => 'is on time and regular in meeting the class',
                'keyword' => 'punctual',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'sentence' => 'assigns fair subject/course requirements',
                'keyword' => 'fair subject/course requirements',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'sentence' => 'sustains the attention of the class for the whole period',
                'keyword' => 'class is listening',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'sentence' => 'presents lesson clearly, methodically, and substantially',
                'keyword' => 'clear presentation of lessons',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'sentence' => 'motivates the students to learn',
                'keyword' => 'motivator',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'facilitates learning with the application of appropriate educational methods and techniques',
                'keyword' => 'teaching strategy',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'shows mastery of the lesson',
                'keyword' => 'mastery of lesson',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'is prepared for the class',
                'keyword' => 'prepared',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'inspires students’ self-reliance in their quest for knowledge',
                'keyword' => 'make students eager to learn',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'knows when the students have difficulty understanding the lesson and finds ways to make it easy',
                'keyword' => 'knows the limit of students understanding',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'integrates values into the lesson',
                'keyword' => 'values oriented',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'Speaks the language of instruction (English or Filipino) clearly and fluently',
                'keyword' => 'speaks language beingu used clearly',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'delivers thought provoking questions',
                'keyword' => 'makes student think more',
                'type' => 4
            ]
        ];
        foreach($questions as $q)
            Question::create($q);
    }
}
