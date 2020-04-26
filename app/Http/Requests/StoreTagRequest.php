<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreTagRequest extends FormRequest
{
    public $validator = null;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tagName' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'tagName.required' => 'Tag name is required.'
        ];
    }

    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}
