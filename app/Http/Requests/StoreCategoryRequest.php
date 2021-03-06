<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreCategoryRequest extends FormRequest
{
    public $validator = null;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'categoryName' => 'required',
            'iconImage'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'categoryName.required' => 'Category name is required.',
            'iconImage.required'    => 'Category Image is required.'
        ];
    }

    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}
