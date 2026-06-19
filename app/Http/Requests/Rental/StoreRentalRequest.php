<?php

namespace App\Http\Requests\Rental;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRentalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $ownedStudio = Rule::exists('studios', 'id')->where(fn ($query) => $query->where('user_id', auth()->id()));
        $ownedConcept = Rule::exists('concepts', 'id')->where(fn ($query) => $query->where('user_id', auth()->id()));
        $ownedCostume = Rule::exists('costumes', 'id')->where(fn ($query) => $query->where('user_id', auth()->id()));

        return [
            'studio_id' => ['required', $ownedStudio],
            'concept_id' => ['required', $ownedConcept],
            'second_concept_id' => ['nullable', 'different:concept_id', $ownedConcept],
            'extra_costume_id' => ['nullable', $ownedCostume],
            'graduation_costume_id' => ['nullable', $ownedCostume],
            'female_accessory_id' => ['nullable', $ownedCostume],
            'male_accessory_id' => ['nullable', $ownedCostume],
            'school_name' => ['required', 'max:255'],
            'class_name' => ['required', 'max:255'],
            'shooting_date' => ['required', 'date'],
            'rental_date' => ['required', 'date'],
            'return_date' => ['required', 'date', 'after_or_equal:rental_date'],
            'note' => ['nullable', 'max:1000'],
            'extra_costume_ids' => ['nullable', 'array'],
            'extra_costume_ids.*' => [$ownedCostume],
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
