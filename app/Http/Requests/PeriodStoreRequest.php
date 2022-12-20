<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeriodStoreRequest extends FormRequest
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
            'semester' => 'required',
            'begin' => 'required',
            'end' => ['required', 'after:begin']
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
            'semester.required' => 'Semester field is required.',
            'begin.required' => 'Period begin date field is required.',
            'end.required' => 'Period end date field is required.',
            'end.after' => 'The end date of the period cannot be the date before it starts.'
        ];
    }
}
