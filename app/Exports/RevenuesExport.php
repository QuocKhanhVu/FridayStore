<?php

namespace App\Exports;

use App\Models\Rental;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RevenuesExport implements FromArray, ShouldAutoSize, WithEvents, WithTitle
{
    protected $filters;

    protected $rentals;

    protected $dataStartRow = 2;

    protected $dataEndRow = 1;

    protected $summaryStartRow = 1;

    protected $totalAmount = 0;

    protected $totalDiscount = 0;

    protected $finalRevenue = 0;

    protected $totalOrders = 0;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Doanh thu';
    }

    public function array(): array
    {
        $this->rentals = Rental::with([
                'studio',
                'concept',
                'secondConcept',
                'graduation',
                'revenues',
            ])

            ->when($this->filters['from'] ?? null, function ($query) {
                $query->whereDate(
                    'shooting_date',
                    '>=',
                    $this->filters['from']
                );
            })

            ->when($this->filters['to'] ?? null, function ($query) {
                $query->whereDate(
                    'shooting_date',
                    '<=',
                    $this->filters['to']
                );
            })

            ->when($this->filters['studio_id'] ?? null, function ($query) {
                $query->where(
                    'studio_id',
                    $this->filters['studio_id']
                );
            })

            ->latest()
            ->get();

        $rows = [];

        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */
        $rows[] = [
            'Mã đơn',
            'Studio',
            'Trường/lớp',
            'Sĩ số',
            'Cử nhân',
            'Concept',
            'Giá/HS',
            'Tổng gốc',
            'CK',
            'Thực nhận',
            'Tổng thực nhận',
            'Ngày chụp',
            'Trạng thái',
        ];

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */
        foreach ($this->rentals as $rental) {

            $revenues = $rental->revenues;

            $revenue1 = $revenues->firstWhere(
                'concept_id',
                $rental->concept_id
            );

            $revenue2 = $revenues->firstWhere(
                'concept_id',
                $rental->second_concept_id
            );

            $totalFinal = $revenues->sum('final_amount');

            $this->totalAmount += $revenues->sum('total_amount');
            $this->totalDiscount += $revenues->sum('discount_amount');
            $this->finalRevenue += $totalFinal;
            $this->totalOrders++;

            /*
            |--------------------------------------------------------------------------
            | Dòng concept 1
            |--------------------------------------------------------------------------
            */
            $rows[] = [
                $rental->code,
                $rental->studio->name ?? '---',
                $rental->school_name,
                $rental->student_count,
                $rental->graduation->name ?? 'Không có',
                $rental->concept->name ?? '---',
                $revenue1->price ?? 0,
                $revenue1->total_amount ?? 0,
                $this->formatDiscount($revenue1),
                $revenue1->final_amount ?? 0,
                $totalFinal,
                $this->formatDate($rental->shooting_date),
                $this->formatStatus($rental->status),
            ];

            /*
            |--------------------------------------------------------------------------
            | Dòng concept 2
            |--------------------------------------------------------------------------
            */
            $rows[] = [
                '',
                '',
                $rental->class_name,
                '',
                '',
                $rental->secondConcept->name ?? 'Không có',
                $revenue2->price ?? 0,
                $revenue2->total_amount ?? 0,
                $this->formatDiscount($revenue2),
                $revenue2->final_amount ?? 0,
                '',
                '',
                '',
            ];
        }

        $this->dataEndRow = count($rows);

        /*
        |--------------------------------------------------------------------------
        | Dòng trống
        |--------------------------------------------------------------------------
        */
        $rows[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        $this->summaryStartRow = count($rows) + 1;

        /*
        |--------------------------------------------------------------------------
        | Tổng hợp
        |--------------------------------------------------------------------------
        */
        $rows[] = [
            'Tổng Hợp',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        $rows[] = [
            'Từ ngày',
            $this->formatDate($this->filters['from'] ?? null),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        $rows[] = [
            'Đến ngày',
            $this->formatDate($this->filters['to'] ?? null),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        $rows[] = [
            'Số lớp',
            $this->totalOrders,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        $rows[] = [
            'Tổng tiền (trước chiết khấu)',
            $this->totalAmount,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        $rows[] = [
            'Chiết khấu',
            $this->totalDiscount,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        $rows[] = [
            'Thực nhận',
            $this->finalRevenue,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        return $rows;
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();

                /*
                |--------------------------------------------------------------------------
                | Merge các dòng dữ liệu
                |--------------------------------------------------------------------------
                */
                for ($row = $this->dataStartRow; $row <= $this->dataEndRow; $row += 2) {

                    $nextRow = $row + 1;

                    $sheet->mergeCells("A{$row}:A{$nextRow}");
                    $sheet->mergeCells("B{$row}:B{$nextRow}");
                    $sheet->mergeCells("D{$row}:D{$nextRow}");
                    $sheet->mergeCells("E{$row}:E{$nextRow}");
                    $sheet->mergeCells("K{$row}:K{$nextRow}");
                    $sheet->mergeCells("L{$row}:L{$nextRow}");
                    $sheet->mergeCells("M{$row}:M{$nextRow}");
                }

                /*
                |--------------------------------------------------------------------------
                | Merge phần tổng hợp
                |--------------------------------------------------------------------------
                */
                $summaryTitleRow = $this->summaryStartRow;

                $sheet->mergeCells("A{$summaryTitleRow}:B{$summaryTitleRow}");

                /*
                |--------------------------------------------------------------------------
                | Độ rộng cột
                |--------------------------------------------------------------------------
                */
                $sheet->getColumnDimension('A')->setWidth(16);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(10);
                $sheet->getColumnDimension('E')->setWidth(18);
                $sheet->getColumnDimension('F')->setWidth(22);
                $sheet->getColumnDimension('G')->setWidth(15);
                $sheet->getColumnDimension('H')->setWidth(16);
                $sheet->getColumnDimension('I')->setWidth(18);
                $sheet->getColumnDimension('J')->setWidth(16);
                $sheet->getColumnDimension('K')->setWidth(18);
                $sheet->getColumnDimension('L')->setWidth(16);
                $sheet->getColumnDimension('M')->setWidth(16);

                /*
                |--------------------------------------------------------------------------
                | Style toàn sheet
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle("A1:M{$highestRow}")
                    ->getFont()
                    ->setName('Times New Roman')
                    ->setSize(12);

                $sheet->getStyle("A1:M{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);

                /*
                |--------------------------------------------------------------------------
                | Header
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle('A1:M1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'EDEDED',
                        ],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | Border bảng dữ liệu
                |--------------------------------------------------------------------------
                */
                if ($this->dataEndRow >= 1) {
                    $sheet->getStyle("A1:M{$this->dataEndRow}")
                        ->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                ],
                            ],
                        ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Border phần tổng hợp
                |--------------------------------------------------------------------------
                */
                $summaryEndRow = $summaryTitleRow + 6;

                $sheet->getStyle("A{$summaryTitleRow}:B{$summaryEndRow}")
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                $sheet->getStyle("A{$summaryTitleRow}:B{$summaryTitleRow}")
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'F2F2F2',
                            ],
                        ],
                    ]);

                /*
                |--------------------------------------------------------------------------
                | Format tiền
                |--------------------------------------------------------------------------
                | G: Giá/HS
                | H: Tổng gốc
                | J: Thực nhận
                | K: Tổng thực nhận
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle("G2:H{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0"đ"');

                $sheet->getStyle("J2:K{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0"đ"');

                $sheet->getStyle("B" . ($summaryTitleRow + 4) . ":B" . ($summaryTitleRow + 6))
                    ->getNumberFormat()
                    ->setFormatCode('#,##0"đ"');

                /*
                |--------------------------------------------------------------------------
                | Chiều cao dòng
                |--------------------------------------------------------------------------
                */
                $sheet->getRowDimension(1)->setRowHeight(30);

                for ($row = 2; $row <= $this->dataEndRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(30);
                }

                /*
                |--------------------------------------------------------------------------
                | Căn trái cột trường/lớp và concept
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle("C2:C{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->getStyle("F2:F{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                /*
                |--------------------------------------------------------------------------
                | Căn giữa phần tổng hợp
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle("A{$summaryTitleRow}:A{$summaryEndRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                /*
                |--------------------------------------------------------------------------
                | In đậm cột tổng thực nhận và ô thực nhận tổng hợp
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle("K2:K{$this->dataEndRow}")
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle("B{$summaryEndRow}")
                    ->getFont()
                    ->setBold(true);
            },

        ];
    }

    private function formatDiscount($revenue)
    {
        if (!$revenue) {
            return "0%\n-0đ";
        }

        return ($revenue->discount_percent ?? 0)
            . "%\n-"
            . number_format($revenue->discount_amount ?? 0)
            . "đ";
    }

    private function formatStatus($status)
    {
        if ($status == 'renting') {
            return 'Đang thuê';
        }

        if ($status == 'processing') {
            return 'Đang xử lý';
        }

        return 'Hoàn thành';
    }

    private function formatDate($date)
    {
        if (!$date) {
            return '---';
        }

        return Carbon::parse($date)->format('d/m/Y');
    }
}