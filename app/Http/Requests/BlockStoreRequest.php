<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlockStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'course_id' => 'required',
            'period_id' => 'required',
            'year_level' => 'required',
            'section' => 'required'
        ];
    }

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'course_id.required' => 'Course field is required.',
            'period_id.required' => 'Period field is required.',
            'year_level.required' => 'Year level field is required.',
            'sectionn' => 'Section field is required.'
        ];
    }
}
