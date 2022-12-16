<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'user_id', 'period_id', 'course_id', 'year_level', 'status'];

    //process enrollment
    public static function process($request, Enrollment $enroll)
    {
        //Adds to block if approved
        if($request['decision'])
        {
            $student = Student::where('user_id', '=', $enroll->user_id)
                            -> get()
                            -> first();

            if($enroll->type == 0)
            {
                if($enroll->year_level == 1 || $student->section == NULL) //first year or transferee dretso 2nd year or so
                {
                    //auto-assign to section
                    //get current blocks
                    $blocks = Block::where('period_id', '=', $enroll->period_id)
                                    -> where('course_id', '=', $enroll->course_id)
                                    -> where('year_level', '=', $enroll->year_level)
                                    -> get()
                                    -> first();
                    //create new blocks starting from section 1
                    if(empty($blocks))
                    {
                        $block = Block::create([
                            'course_id' => $enroll->course_id,
                            'year_level' => $enroll->year_level,
                            'section' => 1,
                            'period_id' => $enroll->period_id
                        ]);

                        if(!$block)
                            return back()->with('message', 'Error in creating block.');

                        //Add student to block
                        if(!BlockStudent::create([
                            'block_id' => $block->id,
                            'user_id' => $enroll->user_id
                        ]))
                            return back()->with('message', 'Error in adding student to new section after creating block.');

                        //Add block subjects
                        $subject = Subject::where('year_level', $block->year_level)
                                        -> where('semester', $block->period->semester)
                                        -> latest('id')
                                        -> get();
                        
                        foreach($subject as $det)
                        {
                            $klase = Klase::create([
                                'subject_id' => $det->id,
                                'block_id' => $block->id
                            ]);

                            if(!$klase)
                                return back()->with('message', 'Error in creating class.');
                            
                            if(!KlaseStudent::create([
                                'klase_id' => $klase->id,
                                'user_id' => $enroll->user_id
                            ]))
                                return back()->with('message', 'Error in adding student to class.');
                        }
                    }
                    else
                    {
                        //Add student to block
                        if(!BlockStudent::create([
                            'block_id' => $blocks->id,
                            'user_id' => $enroll->user_id
                        ]))
                            return back()->with('message', 'Error in adding student to latest block.');

                        //Add Students to Class
                        $klases = Klase::where('block_id', $blocks->id)
                                    -> latest('id')
                                    -> get();

                        foreach($klases as $det)
                        {
                            if(!KlaseStudent::create([
                                'klase_id' => $det->id,
                                'user_id' => $enroll->user_id
                            ]))
                                return back()->with('message', 'Error in adding student to class.');
                        }
                        
                        $maxStudentPerBlock = 50;
                        //Count students from block
                        $studs = BlockStudent::where('block_id', '=', $blocks->id)
                                            -> get();

                        $studNum = $studs->count();

                        if($studNum == $maxStudentPerBlock)
                        {
                                $newSection = $blocks->section + 1;

                            $block = Block::create([
                                'course_id' => $enroll->course_id,
                                'year_level' => $enroll->year_level,
                                'section' => $newSection,
                                'period_id' => $enroll->period_id
                            ]);
        
                            if(!$block)
                                return back()->with('message', 'Error in creating new block after max reached.');
                        }
                    }
                }
                else
                {
                    //assign to old section
                    //get old section
                    $sections = Student::select('section')
                                    -> where('user_id', '=', $enroll->user_id)
                                    -> limit(1)
                                    -> get();

                    foreach($sections as $sec)
                        $section = $sec->section;

                    //check if there already is block with this section and year
                    $blocks =  Block::select('id')
                                    -> where('section', '=', $section)
                                    -> where('period_id', '=', $enroll->period_id)
                                    -> get()
                                    -> first();
                    //create block if there isn't
                    if(empty($blocks))
                    {
                        $block = Block::create([
                            'course_id' => $enroll->course_id,
                            'year_level' => $enroll->year_level,
                            'section' => $section,
                            'period_id' => $enroll->period_id
                        ]);

                        if(!$block)
                            return back()->with('message', 'Error in creating block.');

                        //Add block subjects
                        $subject = Subject::where('year_level', $block->year_level)
                                        -> where('semester', $block->period->semester)
                                        -> latest('id')
                                        -> get();
                        
                        foreach($subject as $det)
                        {
                            $klase = Klase::create([
                                'subject_id' => $det->id,
                                'block_id' => $block->id
                            ]);

                            if(!$klase)
                                return back()->with('message', 'Error in creating class.');
                            
                            if(!KlaseStudent::create([
                                'klase_id' => $klase->id,
                                'user_id' => $enroll->user_id
                            ]))
                                return back()->with('message', 'Error in adding student to class.');
                        }

                        //Add student to block
                        if(!BlockStudent::create([
                            'block_id' => $block->id,
                            'user_id' => $enroll->user_id
                        ]))
                            return back()->with('message', 'Error in adding student to old section after creating block.');
                    }
                    else
                    {
                        //Add student to block
                        if(!BlockStudent::create([
                            'block_id' => $blocks->id,
                            'user_id' => $enroll->user_id
                        ]))
                            return back()->with('message', 'Error in adding student to old section.');

                        //Add student to class
                        //Add Students to Class
                        $klases = Klase::where('block_id', $blocks->id)
                                    -> latest('id')
                                    -> get();

                        foreach($klases as $det)
                        {
                            if(!KlaseStudent::create([
                                'klase_id' => $det->id,
                                'user_id' => $enroll->user_id
                            ]))
                                return back()->with('message', 'Error in adding student to class.');
                        }
                    }
                }
            }
            else
            {
                //get blocks with same course and year
                $blocks = Block::where('period_id', $enroll->period_id)
                            -> where('course_id', $enroll->course_id)
                            -> where('year_level', $enroll->year_level)
                            -> latest('id')
                            -> get();

                if(!$blocks->isEmpty())
                {
                    $bArray = [];
                    
                    foreach($blocks as $det)
                        $bArray = array_merge($bArray, [$det->id]);
                    
                    //get the subjects from a random block available
                    $klases = Klase::where('block_id', $bArray[random_int(0, count($bArray) - 1)])
                                -> latest('id')
                                -> get();
                    //get the student's subjects taken
                    $subjectsTaken = EnrollmentDetail::with('enrollSubjects')
                                -> where('enrollment_id', $enroll->id)
                                -> latest('id')
                                -> get()
                                -> first()
                                -> enrollSubjects;
                    //add the student from the classes in that block of the subjects taken
                    foreach($klases as $det)
                    {
                        //add the student to the classes with the subjects taken from that block
                        if($subjectsTaken->where('subject_id', $det->subject_id)->first() != null)
                        {
                            if(!KlaseStudent::create([
                                'klase_id' => $det->id,
                                'user_id' => $enroll->user_id
                            ]))
                                return false;
                        }
                    }
                }
                else
                    return false;
            }
        }

        return true;
    }
    //user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
    //course relationship
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    //period relationship
    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
    //enrollment detail relationship
    public function enrollDetails()
    {
        return $this->hasMany(EnrollmentDetail::class, 'enrollment_id');
    }
}
