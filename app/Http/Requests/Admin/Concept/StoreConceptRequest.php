<?php

namespace App\Http\Requests\Admin\Concept;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreConceptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'thumbnail' => [
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

            'costumes' => [
                'nullable',
                'array'
            ],

            'costumes.*' => [
                Rule::exists('costumes', 'id')->where(fn ($query) => $query->where('user_id', auth()->id()))
            ],
            'price' => [
                'required',
                'numeric',
                'min:0'
            ],
            'discount_percent' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' =>
                'Vui lòng nhập tên concept',

            'name.max' =>
                'Tên concept không được vượt quá 255 ký tự',

            'thumbnail.image' =>
                'File tải lên phải là hình ảnh',

            'thumbnail.mimes' =>
                'Ảnh phải có định dạng jpg, jpeg, png hoặc webp',

            'thumbnail.max' =>
                'Dung lượng ảnh tối đa là 2MB',

            'status.required' =>
                'Vui lòng chọn trạng thái',

            'costumes.array' =>
                'Danh sách trang phục không hợp lệ',

            'costumes.*.exists' =>
                'Trang phục được chọn không tồn tại',
            'price.required' => 'Vui lòng nhập giá concept.',
            'price.numeric' => 'Giá concept phải là số.',
            'price.min' => 'Giá concept phải lớn hơn hoặc bằng 0.',
        ];
    }
}