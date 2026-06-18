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
        $costumeId = $this->route('costume');

        if (is_object($costumeId)) {
            $costumeId = $costumeId->id;
        }

        return [

            'category_id' => [
                'required',
                'exists:costume_categories,id'
            ],

            'code' => [
                'required',
                'max:50',
                Rule::unique('costumes', 'code')
                    ->ignore($costumeId)
            ],

            'name' => [
                'required',
                'max:255'
            ],

            'gender' => [
                'required',
                Rule::in([
                    'male',
                    'female',
                    'unisex'
                ])
            ],

            'rental_price' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'description' => [
                'nullable',
                'string'
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

            'category_id.required' =>
                'Vui lòng chọn loại trang phục',

            'category_id.exists' =>
                'Loại trang phục không tồn tại',

            'code.required' =>
                'Vui lòng nhập mã trang phục',

            'code.unique' =>
                'Mã trang phục đã tồn tại',

            'code.max' =>
                'Mã trang phục tối đa 50 ký tự',

            'name.required' =>
                'Vui lòng nhập tên trang phục',

            'name.max' =>
                'Tên trang phục tối đa 255 ký tự',

            'gender.required' =>
                'Vui lòng chọn giới tính',

            'gender.in' =>
                'Giới tính không hợp lệ',

            'rental_price.numeric' =>
                'Giá thuê phải là số',

            'rental_price.min' =>
                'Giá thuê không được âm',

            'image.image' =>
                'File phải là hình ảnh',

            'image.mimes' =>
                'Ảnh chỉ hỗ trợ jpg, jpeg, png, webp',

            'image.max' =>
                'Ảnh tối đa 2MB',

            'status.required' =>
                'Vui lòng chọn trạng thái',

        ];
    }
}