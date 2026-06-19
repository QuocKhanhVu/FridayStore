<?php

namespace App\Exports;

use App\Models\Rental;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RentalSizeResultExport implements WithMultipleSheets
{
    protected Rental $rental;

    public function __construct(Rental $rental)
    {
        $this->rental = $rental->load([
            'studio',
            'concept.costumes',
            'secondConcept.costumes',
            'extraCostumes',
            'graduation',
            'femaleAccessory',
            'maleAccessory',

            // Quan hệ dùng cho sheet kết quả size
            'students.sizes.size',

            // Quan hệ thêm để sheet "Phiếu gom size" lấy được tên trang phục
            'students.sizes.costume',
        ]);
    }

    public function sheets(): array
    {
        $sheets = [];

        $costumes = $this->getSizeableCostumes();

        $chunks = $costumes->chunk(3);

        foreach ($chunks as $index => $group) {
            $sheets[] = new RentalSizeResultSheetExport(
                $this->rental,
                $group,
                $index + 1
            );
        }

        if (empty($sheets)) {
            $sheets[] = new RentalSizeResultSheetExport(
                $this->rental,
                collect(),
                1
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Thêm phiếu gom size, mỗi sheet 2 size
        |--------------------------------------------------------------------------
        */
        foreach (RentalSizePickingSheet::makeSheets($this->rental) as $sheet) {
            $sheets[] = $sheet;
        }

        return $sheets;
    }

    private function getSizeableCostumes()
    {
        $costumes = collect();

        if ($this->rental->concept) {
            $costumes = $costumes->merge(
                $this->rental->concept->costumes
            );
        }

        if ($this->rental->secondConcept) {
            $costumes = $costumes->merge(
                $this->rental->secondConcept->costumes
            );
        }

        if ($this->rental->extraCostumes && $this->rental->extraCostumes->count()) {
            $costumes = $costumes->merge(
                $this->rental->extraCostumes
            );
        }

        return $costumes
            ->unique('id')
            ->filter(function ($costume) {
                return (int) $costume->has_size === 1;
            })
            ->values();
    }
}