<?php

namespace App\Http\Requests\Admin\Size;

use Illuminate\Foundation\Http\FormRequest;

class StoreSizeRequest extends FormRequest
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

            'sizes' => [
                'required',
                'array',
                'min:1'
            ],

            'sizes.*.size_name' => [
                'required',
                'max:50'
            ],

            'sizes.*.height_from' => [
                'required',
                'numeric',
                'min:0'
            ],

            'sizes.*.height_to' => [
                'required',
                'numeric',
                'min:0'
            ],

            'sizes.*.weight_from' => [
                'required',
                'numeric',
                'min:0'
            ],

            'sizes.*.weight_to' => [
                'required',
                'numeric',
                'min:0'
            ],

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            foreach ($this->sizes ?? [] as $index => $size) {

                // Chiều cao

                if (
                    isset($size['height_from']) &&
                    isset($size['height_to']) &&
                    $size['height_to'] < $size['height_from']
                ) {
                    $validator->errors()->add(
                        "sizes.$index.height_to",
                        "Chiều cao đến phải lớn hơn hoặc bằng chiều cao từ"
                    );
                }

                // Cân nặng

                if (
                    isset($size['weight_from']) &&
                    isset($size['weight_to']) &&
                    $size['weight_to'] < $size['weight_from']
                ) {
                    $validator->errors()->add(
                        "sizes.$index.weight_to",
                        "Cân nặng đến phải lớn hơn hoặc bằng cân nặng từ"
                    );
                }
            }
        });
    }

    public function attributes(): array
    {
        return [

            'costume_id' => 'trang phục',

            'sizes.*.size_name' => 'size',

            'sizes.*.height_from' => 'chiều cao từ',

            'sizes.*.height_to' => 'chiều cao đến',

            'sizes.*.weight_from' => 'cân nặng từ',

            'sizes.*.weight_to' => 'cân nặng đến',

        ];
    }

    public function messages(): array
    {
        return [

            'costume_id.required' =>
                'Vui lòng chọn trang phục',

            'costume_id.exists' =>
                'Trang phục không tồn tại',

            'sizes.required' =>
                'Vui lòng nhập ít nhất một size',

            'sizes.*.size_name.required' =>
                'Tên size không được để trống',

            'sizes.*.height_from.required' =>
                'Vui lòng nhập chiều cao từ',

            'sizes.*.height_to.required' =>
                'Vui lòng nhập chiều cao đến',

            'sizes.*.weight_from.required' =>
                'Vui lòng nhập cân nặng từ',

            'sizes.*.weight_to.required' =>
                'Vui lòng nhập cân nặng đến',

            'sizes.*.height_from.numeric' =>
                'Chiều cao phải là số',

            'sizes.*.height_to.numeric' =>
                'Chiều cao phải là số',

            'sizes.*.weight_from.numeric' =>
                'Cân nặng phải là số',

            'sizes.*.weight_to.numeric' =>
                'Cân nặng phải là số',

        ];
    }
}