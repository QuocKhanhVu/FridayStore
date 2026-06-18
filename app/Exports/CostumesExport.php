<?php

namespace App\Exports;

use App\Models\Costume;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithMapping
};
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CostumesExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithMapping
{
    protected $keyword;
    protected $gender;
    protected $status;
    protected $stt = 0;

    public function __construct($keyword, $gender, $status)
    {
        $this->keyword = $keyword;
        $this->gender = $gender;
        $this->status = $status;
    }

    public function collection()
    {
        return Costume::query()

            ->when($this->keyword, function ($query) {
                $query->where('name', 'like', '%' . $this->keyword . '%');
            })

            ->when($this->gender, function ($query) {
                $query->where('gender', $this->gender);
            })

            ->when($this->status !== null && $this->status !== '', function ($query) {
                $query->where('status', $this->status);
            })

            ->get();
    }

    public function headings(): array
    {
        return [
            'STT',
            'Mã',
            'Tên trang phục',
            'Giới tính',
            'Giá thuê',
            'Trạng thái',
        ];
    }

    public function map($costume): array
    {
        return [
            ++$this->stt,
            $costume->code,
            $costume->name,
            $costume->gender == 'male' ? 'Nam' : 'Nữ',
            number_format($costume->rental_price, 0, ',', '.') . ' VNĐ',
            $costume->status ? 'Có sẵn' : 'Đang thuê',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4472C4']
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                // Tiêu đề
                $sheet->insertNewRowBefore(1, 2);

                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'DANH SÁCH TRANG PHỤC');

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ],
                    'alignment' => [
                        'horizontal' => 'center'
                    ]
                ]);

                // Viền bảng
                $sheet->getStyle(
                    'A3:' . $lastColumn . ($lastRow + 2)
                )->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin'
                        ]
                    ]
                ]);

                // Căn giữa
                $sheet->getStyle('A3:F' . ($lastRow + 2))
                    ->getAlignment()
                    ->setVertical('center');

                $sheet->getStyle('A3:A' . ($lastRow + 2))
                    ->getAlignment()
                    ->setHorizontal('center');

                $sheet->getStyle('D3:D' . ($lastRow + 2))
                    ->getAlignment()
                    ->setHorizontal('center');

                $sheet->getStyle('F3:F' . ($lastRow + 2))
                    ->getAlignment()
                    ->setHorizontal('center');
            },
        ];
    }
}