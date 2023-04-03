<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'filled',
            ],
            'email' => [
                'required',
                'string',
                'filled',
                'email',
            ],
            'birthdate' => [
                'required',
                'before:today',
                'date',
            ],
            'phone_number' => [
                'required',
                'regex:/(84|0[3|5|7|8|9])[0-9]{8}/',
            ],
            'logo_new' => [
                'nullable',
//                'image',
//                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'course' => [
                'nullable',
                'array',
                'filled',
            ]
        ];
    }
    public function failedValidation(Validator $validator) {
        //write your bussiness logic here otherwise it will give same old JSON response
        throw new HttpResponseException(response()->json($validator->errors()->first(), 422));
    }
}
