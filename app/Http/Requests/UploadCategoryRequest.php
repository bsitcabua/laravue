<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UploadCategoryRequest extends FormRequest
{
    public $validator = null;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg,bmp|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'File is required.',
            'file.mimes'    => 'Image file must be jpeg, png, jpg, gif, svg, or bmp',
            'file.max'      => 'The image file size may not be greater than 2048 kilobytes'
        ];
    }

    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}
