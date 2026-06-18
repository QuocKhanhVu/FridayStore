<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class InventoryExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    public function collection()
    {
        return Inventory::with([
            'costume',
            'size'
        ])
        ->get()
        ->map(function ($item) {

            return [

                $item->costume?->name,

                $item->size?->size_name,

                $item->quantity,

                $item->rented_quantity,

                $item->broken_quantity,

                $item->lost_quantity,

                $item->quantity
                - $item->rented_quantity
                - $item->broken_quantity
                - $item->lost_quantity

            ];
        });
    }

    public function headings(): array
    {
        return [

            'Trang phục',

            'Size',

            'Tồn kho',

            'Đang thuê',

            'Hỏng',

            'Mất',

            'Khả dụng'

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                // Chèn 2 dòng đầu

                $sheet->insertNewRowBefore(1, 2);

                // Tiêu đề

                $sheet->mergeCells('A1:G1');

                $sheet->setCellValue(
                    'A1',
                    'BÁO CÁO TỒN KHO TRANG PHỤC'
                );

                // Ngày xuất

                $sheet->mergeCells('A2:G2');

                $sheet->setCellValue(
                    'A2',
                    'Ngày xuất: ' . now()->format('d/m/Y H:i')
                );

                // Style tiêu đề

                $sheet->getStyle('A1')->applyFromArray([

                    'font' => [

                        'bold' => true,

                        'size' => 16

                    ],

                    'alignment' => [

                        'horizontal' =>
                            Alignment::HORIZONTAL_CENTER

                    ]

                ]);

                // Style ngày xuất

                $sheet->getStyle('A2')->applyFromArray([

                    'alignment' => [

                        'horizontal' =>
                            Alignment::HORIZONTAL_CENTER

                    ]

                ]);

                // Header

                $sheet->getStyle('A3:G3')->applyFromArray([

                    'font' => [

                        'bold' => true,

                        'color' => [

                            'rgb' => 'FFFFFF'

                        ]

                    ],

                    'alignment' => [

                        'horizontal' =>
                            Alignment::HORIZONTAL_CENTER,

                        'vertical' =>
                            Alignment::VERTICAL_CENTER

                    ],

                    'fill' => [

                        'fillType' =>
                            Fill::FILL_SOLID,

                        'startColor' => [

                            'rgb' => '198754'

                        ]

                    ]

                ]);

                $highestRow = $sheet->getHighestRow();

                // Dòng tổng

                $totalRow = $highestRow + 1;

                $sheet->setCellValue(
                    'A' . $totalRow,
                    'TỔNG'
                );

                $sheet->setCellValue(
                    'C' . $totalRow,
                    '=SUM(C4:C' . ($totalRow - 1) . ')'
                );

                $sheet->setCellValue(
                    'D' . $totalRow,
                    '=SUM(D4:D' . ($totalRow - 1) . ')'
                );

                $sheet->setCellValue(
                    'E' . $totalRow,
                    '=SUM(E4:E' . ($totalRow - 1) . ')'
                );

                $sheet->setCellValue(
                    'F' . $totalRow,
                    '=SUM(F4:F' . ($totalRow - 1) . ')'
                );

                $sheet->setCellValue(
                    'G' . $totalRow,
                    '=SUM(G4:G' . ($totalRow - 1) . ')'
                );

                $sheet->getStyle(
                    'A' . $totalRow . ':G' . $totalRow
                )->getFont()->setBold(true);

                // Kẻ khung

                $sheet->getStyle(
                    'A1:G' . $totalRow
                )
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(
                    Border::BORDER_THIN
                );

                // Căn giữa dữ liệu

                $sheet->getStyle(
                    'B4:G' . $totalRow
                )
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                );
            }

        ];
    }
}