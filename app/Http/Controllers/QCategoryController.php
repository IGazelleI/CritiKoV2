<?php

namespace App\Http\Controllers;

use App\Models\QCategory;
use Illuminate\Http\Request;
use App\Http\Requests\QCategoryStoreRequest;

class QCategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QCategoryStoreRequest $request)
    {
        if(!QCategory::create($request->all()))
            return back()->with('message', 'Error in adding question category. Please try again.');

        return back()->with('message', 'Question category added.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QCategoryStoreRequest $request)
    {
        $category = QCategory::find($request->id);

        if(!$category->update([
            'type' => $request->q_type,
            'q_category_id' => $request->name,
        ]))
            return back()->with('message', 'Error in updating question category. Please try again.');

        return back()->with('message', 'Question category updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = QCategory::find($request->id);

        if(!$category->delete())
            return back()->with('message', 'Error in deleting question category. Please try again.');

        return back()->with('message', 'Question category deleted.');
    }
}
