<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCostumeRequest extends FormRequest
{
    /**
     * Authorize
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('costumes', 'code')->where(fn ($query) => $query->where('user_id', auth()->id()))
            ],

            'category_id' => [
                'required',
                'exists:costume_categories,id'
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
                'string'
            ],

            'status' => [
                'required',
                'boolean'
            ],

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'name.required' =>
                'Vui lòng nhập tên trang phục.',

            'code.required' =>
                'Vui lòng nhập mã trang phục.',

            'code.unique' =>
                'Mã trang phục đã tồn tại.',

            'category_id.required' =>
                'Vui lòng chọn loại trang phục.',

            'category_id.exists' =>
                'Loại trang phục không hợp lệ.',

            'gender.required' =>
                'Vui lòng chọn giới tính.',

            'rental_price.required' =>
                'Vui lòng nhập giá thuê.',

            'rental_price.numeric' =>
                'Giá thuê phải là số.',

            'rental_price.min' =>
                'Giá thuê phải lớn hơn hoặc bằng 0.',

            'image.image' =>
                'File tải lên phải là hình ảnh.',

            'image.mimes' =>
                'Ảnh chỉ được phép jpg, jpeg, png, webp.',

            'image.max' =>
                'Ảnh tối đa 2MB.',

            'status.required' =>
                'Vui lòng chọn trạng thái.',

        ];
    }
}