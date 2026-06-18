<?php

namespace App\Exports;

use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class RentalSizeResultSheetExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    WithTitle
{
    protected Rental $rental;
    protected Collection $costumes;
    protected int $sheetNumber;

    public function __construct(
        Rental $rental,
        Collection $costumes,
        int $sheetNumber
    ) {
        $this->rental = $rental->load([
            'studio',
            'concept.costumes',
            'secondConcept.costumes',
            'extraCostume',
            'graduation',
            'femaleAccessory',
            'maleAccessory',
            'students.sizes.size',
        ]);

        $this->costumes = $costumes;
        $this->sheetNumber = $sheetNumber;
    }

    public function title(): string
    {
        return 'Trang ' . $this->sheetNumber;
    }

    public function headings(): array
    {
        $headings = [
            'STT',
            'Họ và tên',
            'Giới tính',
            'Chiều cao',
            'Cân nặng',
        ];

        foreach ($this->costumes as $costume) {
            $headings[] = $costume->name;
        }

        return $headings;
    }

    public function collection()
    {
        $rows = collect();

        foreach ($this->rental->students as $index => $student) {

            $row = [
                $index + 1,
                $student->full_name,
                $student->gender === 'male' ? 'Nam' : 'Nữ',
                $student->height,
                $student->weight,
            ];

            foreach ($this->costumes as $costume) {

                $size = $student->sizes
                    ->where('costume_id', $costume->id)
                    ->first();

                $row[] = $size
                    ? ($size->size?->size_name ?? '0')
                    : '0';
            }

            $rows->push($row);
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $students = $this->rental->students;

                $male = $students->where('gender', 'male')->count();
                $female = $students->where('gender', 'female')->count();

                $sheet->insertNewRowBefore(1, 8);

                $headerText =
                    ($this->rental->studio?->name ?? '') . ' ' .
                    ($this->rental->shooting_date
                        ? Carbon::parse($this->rental->shooting_date)->format('d.m')
                        : '') . ' ' .
                    ($this->rental->class_name ?? '') . ' ' .
                    ($this->rental->school_name ?? '');

                $sheet->setCellValue('B1', trim($headerText));

                $sheet->setCellValue(
                    'B2',
                    'Chụp ngày: ' . (
                        $this->rental->shooting_date
                            ? Carbon::parse($this->rental->shooting_date)->format('d/m/Y')
                            : ''
                    )
                );

                $sheet->setCellValue('B3', 'Lớp: ' . $this->rental->class_name);
                $sheet->setCellValue('B4', 'Trường: ' . $this->rental->school_name);
                $sheet->setCellValue('B5', 'Sĩ số: ' . $students->count());
                $sheet->setCellValue('B6', 'Nam: ' . $male);
                $sheet->setCellValue('B7', 'Nữ: ' . $female);
                $sheet->setCellValue('B8', 'Concept: ' . $this->buildConceptLine($male, $female));

                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                $sheet->mergeCells('B1:' . $highestColumn . '1');
                $sheet->mergeCells('B8:' . $highestColumn . '8');

                $sheet->getStyle('A1:' . $highestColumn . $highestRow)
                    ->getFont()
                    ->setName('Times New Roman')
                    ->setSize(14);

                $sheet->getStyle('B1')->getFont()->setSize(18)->setBold(true);
                $sheet->getStyle('B2:B8')->getFont()->setBold(true);

                $sheet->getStyle('A9:' . $highestColumn . '9')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb' => 'FFFFFF'],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => '198754'],
                        ],
                    ]);

                $sheet->getStyle('A9:' . $highestColumn . $highestRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                $sheet->getStyle('A:A')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('C:Z')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('B8')
                    ->getAlignment()
                    ->setWrapText(true);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(35);
                $sheet->getColumnDimension('C')->setWidth(13);
                $sheet->getColumnDimension('D')->setWidth(13);
                $sheet->getColumnDimension('E')->setWidth(13);

                $column = 'F';

                while ($column <= $highestColumn) {
                    $sheet->getColumnDimension($column)->setWidth(20);
                    $column++;
                }

                $sheet->getRowDimension(8)->setRowHeight(45);

                for ($i = 10; $i <= $highestRow; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(28);
                }

                $sheet->getPageSetup()
                    ->setPaperSize(PageSetup::PAPERSIZE_A4)
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0);

                $sheet->getPageMargins()->setTop(0.4);
                $sheet->getPageMargins()->setBottom(0.4);
                $sheet->getPageMargins()->setLeft(0.3);
                $sheet->getPageMargins()->setRight(0.3);

                $sheet->freezePane('A10');
            },
        ];
    }

    private function buildConceptLine(int $male, int $female): string
    {
        $items = collect();

        if ($this->rental->concept) {
            $items = $items->merge(
                $this->rental->concept->costumes->pluck('name')
            );
        }

        if ($this->rental->secondConcept) {
            $items = $items->merge(
                $this->rental->secondConcept->costumes->pluck('name')
            );
        }

        if ($this->rental->extraCostume) {
            $items->push(
                $this->rental->extraCostume->name
            );
        }

        if ($this->rental->graduation) {
            $items->push(
                $this->rental->students->count() . ' ' . $this->rental->graduation->name
            );
        }

        if ($this->rental->femaleAccessory) {
            $items->push(
                $female . ' ' . $this->rental->femaleAccessory->name
            );
        }

        if ($this->rental->maleAccessory) {
            $items->push(
                $male . ' ' . $this->rental->maleAccessory->name
            );
        }

        return $items
            ->filter()
            ->unique()
            ->implode(', ');
    }
}
