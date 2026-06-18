<?php

namespace App\Http\Requests\Rental;

use Illuminate\Foundation\Http\FormRequest;

class ImportStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'file' => [
                'required',
                'mimes:xlsx,xls'
            ],

            'start_row' => [
                'required',
                'integer',
                'min:1'
            ],

            'name_column' => [
                'required'
            ],

            'gender_column' => [
                'required'
            ],

            'height_column' => [
                'required'
            ],

            'weight_column' => [
                'required'
            ]

        ];
    }
}