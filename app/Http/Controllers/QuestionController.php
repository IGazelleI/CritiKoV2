<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests\QuestionStoreRequest;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null)
    {
        $cat = QCategory::where(function ($query) use ($type)
                        {
                            if($type != null)
                                $query->where('type', $type);
                        })
                        -> latest('id')
                        -> get();

        $question = new Collection();
        
        foreach($cat as $det)
        {
            foreach($det->questions as $q)
                $question->push($q);
        }

        return view('question.index', compact('question', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionStoreRequest $request)
    {
        if(!Question::create($request->all()))
            return back()->with('message', 'Error in adding question. Please try again.');

        return back()->with('message', 'Question added.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionStoreRequest $request)
    {
        $question = Question::find($request->id);

        if(!$question->update([
            'q_type_id' => $request->q_type_id,
            'q_category_id' => $request->q_category_id,
            'sentence' => $request->sentence,
            'keyword' => $request->keyword
        ]))
            return back()->with('message', 'Error in updating question. Please try again.');

        return back()->with('message', 'Question updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $question = Question::find($request->id);

        if(!$question->delete())
            return back()->with('message', 'Error in deleting question. Please try again.');

        return back()->with('message', 'Question deleted.');
    }
}