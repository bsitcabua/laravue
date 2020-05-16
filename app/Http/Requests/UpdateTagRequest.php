<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UpdateTagRequest extends FormRequest
{
    public $validator = null;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'            => 'required',
            'categoryName'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id.required'           => 'Something went wrong.',
            'categoryName.required' => 'Category name is required.',
        ];
    }

    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}
