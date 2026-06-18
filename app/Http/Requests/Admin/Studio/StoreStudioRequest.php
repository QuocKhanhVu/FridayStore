<?php

namespace App\Http\Requests\Admin\Studio;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
   public function rules(): array
    {
        return [

            'name' => [
                'required',
                'max:255'
            ],

            'phone' => [
                'required',
                'max:20'
            ],

            'email' => [
                'nullable',
                'email'
            ],

            'address' => [
                'nullable',
                'max:255'
            ],

            'contact_person' => [
                'nullable',
                'max:255'
            ],

            'note' => [
                'nullable'
            ],

            'status' => [
                'nullable'
            ]

        ];
    }

    public function messages(): array
    {
        return [

            'name.required'
                => 'Vui lòng nhập tên studio.',

            'phone.required'
                => 'Vui lòng nhập số điện thoại.',

            'email.email'
                => 'Email không đúng định dạng.'

        ];
    }
}
