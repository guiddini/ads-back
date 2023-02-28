<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpaceRequest extends FormRequest
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
            'name'=>['required', 'string', 'max:191'],
            'desc'=>['required', 'string'],
            'image'=>['required', 'mimes:jpg,jpeg,png'],
            'cat'=>['required'],
            'price'=>['required', 'numeric'],
            'height'=>['required', 'numeric'],
            'width'=>['required', 'numeric'],
            'location'=>['required', 'string']
        ];
    }
}
