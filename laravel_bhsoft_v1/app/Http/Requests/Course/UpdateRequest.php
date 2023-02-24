<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

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
            'name'=> [
                'required',
                'string',
                'filled',
            ],
            'description'=> [
                'nullable',
                'string',
                'max:2048'
            ],
            'start_date'=>[
                'required',
                'before_or_equal:end_date',
                'date',
            ],
            'end_date'=>[
                'required',
                'after_or_equal:start_date',
                'date',
            ],
            //
        ];
    }
}
