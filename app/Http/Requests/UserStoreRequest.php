<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
   /*  protected $stopOnFirstFailure = true; */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'id_number' => ['required', Rule::unique('students', 'id_number')],
            'fname' => 'required',
            'lname' => 'required',
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
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
            'id_number.required' => 'ID Number is required.',
            'fname.required' => 'First name is required.',
            'lname.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'The password does not match.',
            'email.unique' => 'Email is already taken.',
            'id_number' => 'ID Number is already taken.'
        ];
    }
}
