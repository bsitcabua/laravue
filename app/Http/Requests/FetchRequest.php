<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class FetchRequest extends FormRequest
{
    public $validator = null;

    public function authorize() 
    {
        return true;
    }

    public function rules() 
    {
        return [
            'user_confirmed' => 'required'
        ];
    }

    public function messages() 
    {
        return [
            'user_confirmed.required' => 'Opps something went wrong!'
        ];
    }

    protected function failedValidation($validator) 
    {
        $this->validator = $validator;
    }
}
