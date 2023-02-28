<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'fname'=>['required', 'string', 'max:191'],
            'lname'=>['required', 'string', 'max:191'],
            'picture'=>['required', 'mimes:jpg,jpeg,png'],
            'email'=>['required', 'string', 'email', 'unique:users'],
            'phone'=>['required', 'numeric', 'digits:10'],
            'dob'=>['required'],
            'address'=>['required', 'string'],
            'password'=>['required', 'confirmed', 'min:8', Password::defaults()],
        ];
    }
}
