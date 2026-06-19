<?php

namespace App\Http\Requests\Admin\Studio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studioId = $this->route('studio')->id;

        return [

            'name' => [
                'required',
                'max:255'
            ],

            'contact_person' => [
                'nullable',
                'max:255'
            ],

            'phone' => [
                'required',
                'max:20',
                Rule::unique('studios', 'phone')->where(fn ($query) => $query->where('user_id', auth()->id()))->ignore($studioId)
            ],

            'email' => [
                'nullable',
                'email'
            ],

            'address' => [
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

            'phone.unique'
                => 'Số điện thoại đã tồn tại.',

            'email.email'
                => 'Email không đúng định dạng.'

        ];
    }
}