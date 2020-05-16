<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreCategotyRequest extends FormRequest
{
    public $validator = null;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tagCategory' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'tagCategory.required' => 'Category name is required.'
        ];
    }

    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}
