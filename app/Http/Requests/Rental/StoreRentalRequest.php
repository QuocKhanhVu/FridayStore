<?php

namespace App\Http\Requests\Rental;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'studio_id' => 'required|exists:studios,id',
            'concept_id' => 'required|exists:concepts,id',
            'second_concept_id' => 'nullable|different:concept_id|exists:concepts,id',
            'extra_costume_id' => 'nullable|exists:costumes,id',
            'graduation_costume_id' => 'nullable|exists:costumes,id',
            'female_accessory_id' => 'nullable|exists:costumes,id',
            'male_accessory_id' => 'nullable|exists:costumes,id',
            'school_name' => 'required|max:255',
            'class_name' => 'required|max:255',
            'shooting_date' => 'required|date',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'note' => 'nullable|max:1000',
            'extra_costume_ids' => 'nullable|array',
            'extra_costume_ids.*' => 'exists:costumes,id',
        ];
    }

    public function messages(): array
    {
        return [
            'studio_id.required' => 'Vui lòng chọn studio.',
            'concept_id.required' => 'Vui lòng chọn concept 1.',
            'second_concept_id.different' => 'Concept 2 không được trùng với Concept 1.',
            'school_name.required' => 'Vui lòng nhập tên trường.',
            'class_name.required' => 'Vui lòng nhập tên lớp.',
            'shooting_date.required' => 'Vui lòng chọn ngày chụp.',
            'rental_date.required' => 'Vui lòng chọn ngày thuê.',
            'return_date.required' => 'Vui lòng chọn ngày trả.',
            'return_date.after_or_equal' => 'Ngày trả phải lớn hơn hoặc bằng ngày thuê.',
        ];
    }
}
