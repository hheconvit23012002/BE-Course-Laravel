<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name'=> [
                'required',
                'string',
                'filled',
            ],
            'email'=> [
                'required',
                'string',
                'filled',
                'email',
            ],
            'birthdate'=>[
                'required',
                'before:today',
                'date',
            ],
            'phone_number'=>[
                'required',
                'regex:/(84|0[3|5|7|8|9])[0-9]{8}/',
            ],
            'logo'=>[
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'course'=> [
                'required',
                'array',
                'filled',
            ]
            //
        ];
    }
}
