<?php

namespace App\Http\Requests\Admin\Costume;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCostumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $costumeId = $this->route('costume')->id;

        return [

            'category_id' => [
                'required',
                'exists:costume_categories,id'
            ],

            'code' => [
                'required',
                Rule::unique('costumes', 'code')
                    ->ignore($costumeId)
            ],

            'name' => [
                'required',
                'max:255'
            ],

            'gender' => [
                'required',
                'in:male,female,unisex'
            ],

            'rental_price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'has_size' => [
                'required',
                'boolean'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'description' => [
                'nullable',
                'max:1000'
            ],

            'status' => [
                'required',
                'boolean'
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'category_id.required' => 'Vui lòng chọn loại trang phục',

            'code.required' => 'Vui lòng nhập mã trang phục',

            'code.unique' => 'Mã trang phục đã tồn tại',

            'name.required' => 'Vui lòng nhập tên trang phục',

            'rental_price.required' => 'Vui lòng nhập giá thuê',

            'rental_price.numeric' => 'Giá thuê phải là số',

            'image.image' => 'File tải lên phải là hình ảnh',

        ];
    }
}