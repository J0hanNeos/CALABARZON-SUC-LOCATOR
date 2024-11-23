<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Redirect;

class CollegeRequest extends FormRequest
{
    //protected $redirect = '/users/create';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string','min:2'],
            'address' => ['required', 'string', 'min:2'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'website' => ['nullable', 'string'],
            'contact_number' => ['nullable', 'string'],
            'avatar' => ['nullable', 'file', 'mimes:png,jpeg,jpg,gif,bmp']
        ];
    }



    public function messages()
    {
        return [
            //Add your custom error messages here
        ];
    }
}
