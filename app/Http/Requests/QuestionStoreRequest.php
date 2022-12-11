<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionStoreRequest extends FormRequest
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
            'q_type_id' => 'required',
            'q_category_id' => 'required',
            'sentence' => 'required',
            'keyword' => 'required'
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
            'q_type_id.required' => 'Type field is required.',
            'q_category_id' => 'Category field is required.',
            'sentence' => 'Sentence field is required.',
            'keyword' => 'Keyword field is required.'
        ];
    }
}
