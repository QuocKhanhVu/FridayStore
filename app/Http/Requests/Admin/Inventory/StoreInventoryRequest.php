<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'costume_id' => [
                'required',
                'exists:costumes,id'
            ],

            'costume_size_id' => [
                'required',
                'exists:costume_sizes,id'
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],

            'note' => [
                'nullable',
                'max:500'
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'costume_id.required'
                => 'Vui lòng chọn trang phục.',

            'costume_id.exists'
                => 'Trang phục không tồn tại.',

            'costume_size_id.required'
                => 'Vui lòng chọn size.',

            'costume_size_id.exists'
                => 'Size không tồn tại.',

            'quantity.required'
                => 'Vui lòng nhập số lượng.',

            'quantity.integer'
                => 'Số lượng phải là số nguyên.',

            'quantity.min'
                => 'Số lượng phải lớn hơn 0.',

            'note.max'
                => 'Ghi chú không được vượt quá 500 ký tự.',

        ];
    }
}