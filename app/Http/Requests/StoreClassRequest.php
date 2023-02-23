<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'List_Classes.*.Name' => 'required',
            'List_Classes.*.Name_class_en' => 'required',
        ];
    }
    public function messages()
    {
        return [
            "Name.required" => trans("validation.required"),
            "Name_class_en.required" => trans("validation.required"),
        ];
    }
}
