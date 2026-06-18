<?php

namespace App\Exports;

use App\Models\Rental;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class RentalSizePickingSheet implements FromArray, WithEvents, WithTitle
{
    protected Rental $rental;

    protected array $tables;

    protected int $page;

    protected string $mode;

    public function __construct(
        Rental $rental,
        array $tables,
        int $page,
        string $mode = 'pair'
    ) {
        $this->rental = $rental;
        $this->tables = $tables;
        $this->page = $page;
        $this->mode = $mode;
    }

    public static function makeSheets(Rental $rental): array
    {
        $rental->load([
            'students.sizes.costume',
            'students.sizes.size',
        ]);

        $groups = [];

        foreach ($rental->students as $student) {

            foreach ($student->sizes as $assignedSize) {

                if (!$assignedSize->costume || !$assignedSize->size) {
                    continue;
                }

                $costumeId = $assignedSize->costume->id;
                $sizeId = $assignedSize->size->id;

                $costumeName = $assignedSize->costume->name ?? 'Trang phục';
                $sizeName = $assignedSize->size->size_name ?? 'Không size';

                $key = $costumeId . '_' . $sizeId;

                if (!isset($groups[$key])) {
                    $groups[$key] = [
                        'title' => $costumeName . ' size ' . $sizeName,
                        'costume_id' => $costumeId,
                        'costume_name' => $costumeName,
                        'size_id' => $sizeId,
                        'size_name' => $sizeName,
                        'size_order' => self::getSizeOrder($sizeName),
                        'students' => [],
                    ];
                }

                $groups[$key]['students'][] = self::getStudentNameStatic($student);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Sắp xếp:
        | 1. Theo tên trang phục
        | 2. Trong cùng trang phục thì theo thứ tự size: S, M, L, XL...
        |--------------------------------------------------------------------------
        */
        $groups = collect($groups)
            ->sort(function ($a, $b) {

                $costumeCompare = strnatcasecmp(
                    $a['costume_name'],
                    $b['costume_name']
                );

                if ($costumeCompare !== 0) {
                    return $costumeCompare;
                }

                if ($a['size_order'] !== $b['size_order']) {
                    return $a['size_order'] <=> $b['size_order'];
                }

                return strnatcasecmp(
                    $a['size_name'],
                    $b['size_name']
                );
            })
            ->values()
            ->all();

        $normalTables = [];
        $bigTables = [];

        foreach ($groups as $group) {

            $students = array_values($group['students']);
            $totalStudents = count($students);

            /*
            |--------------------------------------------------------------------------
            | Size <= 24 học sinh:
            | 1 bảng nhỏ, mỗi sheet gom 2 size
            |--------------------------------------------------------------------------
            */
            if ($totalStudents <= 24) {
                $normalTables[] = [
                    'title' => $group['title'] . ': ' . $totalStudents,
                    'students' => $students,
                ];

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Size > 24 học sinh:
            | In riêng 1 sheet, dùng cả trang A4
            | 1 sheet riêng chứa tối đa 54 tên: 18 dòng x 3 cột
            |--------------------------------------------------------------------------
            */
            $chunks = array_chunk($students, 54);

            foreach ($chunks as $index => $chunk) {

                $title = $group['title'] . ': ' . $totalStudents;

                if (count($chunks) > 1) {
                    $title .= ' (' . ($index + 1) . '/' . count($chunks) . ')';
                }

                $bigTables[] = [
                    'title' => $title,
                    'students' => $chunk,
                ];
            }
        }

        if (empty($normalTables) && empty($bigTables)) {
            $normalTables[] = [
                'title' => 'Chưa có dữ liệu chia size',
                'students' => [],
            ];
        }

        $sheets = [];

        /*
        |--------------------------------------------------------------------------
        | Sheet thường:
        | Mỗi sheet có 2 size
        |--------------------------------------------------------------------------
        */
        $normalPages = array_chunk($normalTables, 2);

        foreach ($normalPages as $pageTables) {
            $sheets[] = new self(
                $rental,
                $pageTables,
                count($sheets) + 1,
                'pair'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sheet riêng:
        | Mỗi sheet có 1 size lớn
        |--------------------------------------------------------------------------
        */
        foreach ($bigTables as $bigTable) {
            $sheets[] = new self(
                $rental,
                [$bigTable],
                count($sheets) + 1,
                'single'
            );
        }

        return $sheets;
    }

    public function title(): string
    {
        return 'Gom size ' . $this->page;
    }

    public function array(): array
    {
        $rows = [];

        /*
        |--------------------------------------------------------------------------
        | Cố định 19 dòng x 3 cột
        |--------------------------------------------------------------------------
        */
        for ($i = 1; $i <= 19; $i++) {
            $rows[] = [
                '',
                '',
                '',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Sheet riêng cho size > 24 học sinh
        |--------------------------------------------------------------------------
        */
        if ($this->mode === 'single') {

            if (isset($this->tables[0])) {
                $this->fillFullPageTable(
                    $rows,
                    $this->tables[0]
                );
            }

            return $rows;
        }

        /*
        |--------------------------------------------------------------------------
        | Sheet thường:
        | Bảng 1: dòng 1 - 9
        | Dòng 10: dòng trống
        | Bảng 2: dòng 11 - 19
        |--------------------------------------------------------------------------
        */
        if (isset($this->tables[0])) {
            $this->fillSmallTable(
                $rows,
                $this->tables[0],
                0
            );
        }

        if (isset($this->tables[1])) {
            $this->fillSmallTable(
                $rows,
                $this->tables[1],
                10
            );
        }

        return $rows;
    }

    private function fillSmallTable(
        array &$rows,
        array $table,
        int $startIndex
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Dòng tiêu đề
        |--------------------------------------------------------------------------
        */
        $rows[$startIndex][0] = $table['title'];

        $students = $table['students'];

        $cellIndex = 0;

        /*
        |--------------------------------------------------------------------------
        | 8 dòng x 3 cột = 24 ô tên
        |--------------------------------------------------------------------------
        */
        for ($row = $startIndex + 1; $row <= $startIndex + 8; $row++) {

            for ($col = 0; $col <= 2; $col++) {

                $rows[$row][$col] = $students[$cellIndex] ?? '';

                $cellIndex++;
            }
        }
    }

    private function fillFullPageTable(
        array &$rows,
        array $table
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Dòng 1 là tiêu đề
        |--------------------------------------------------------------------------
        */
        $rows[0][0] = $table['title'];

        $students = $table['students'];

        $cellIndex = 0;

        /*
        |--------------------------------------------------------------------------
        | Dòng 2 -> 19:
        | 18 dòng x 3 cột = 54 ô tên
        |--------------------------------------------------------------------------
        */
        for ($row = 1; $row <= 18; $row++) {

            for ($col = 0; $col <= 2; $col++) {

                $rows[$row][$col] = $students[$cellIndex] ?? '';

                $cellIndex++;
            }
        }
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | Cấu hình trang A4
                |--------------------------------------------------------------------------
                */
                $sheet->getPageSetup()
                    ->setPaperSize(PageSetup::PAPERSIZE_A4);

                $sheet->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_PORTRAIT);

                $sheet->getPageSetup()
                    ->setFitToPage(true);

                $sheet->getPageSetup()
                    ->setFitToWidth(1);

                $sheet->getPageSetup()
                    ->setFitToHeight(1);

                $sheet->getPageSetup()
                    ->setPrintArea('A1:C19');

                /*
                |--------------------------------------------------------------------------
                | Lề khoảng 1cm
                | Excel dùng inch, 1cm ≈ 0.39 inch
                |--------------------------------------------------------------------------
                */
                $sheet->getPageMargins()->setTop(0.39);
                $sheet->getPageMargins()->setBottom(0.39);
                $sheet->getPageMargins()->setLeft(0.39);
                $sheet->getPageMargins()->setRight(0.39);

                /*
                |--------------------------------------------------------------------------
                | 3 cột bằng nhau, cố định
                |--------------------------------------------------------------------------
                */
                $sheet->getColumnDimension('A')->setWidth(27);
                $sheet->getColumnDimension('B')->setWidth(27);
                $sheet->getColumnDimension('C')->setWidth(27);

                /*
                |--------------------------------------------------------------------------
                | Font toàn sheet
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle('A1:C19')
                    ->getFont()
                    ->setName('Times New Roman')
                    ->setSize(12);

                $sheet->getStyle('A1:C19')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setWrapText(true);

                /*
                |--------------------------------------------------------------------------
                | Style theo loại sheet
                |--------------------------------------------------------------------------
                */
                if ($this->mode === 'single') {
                    $this->styleSinglePage($sheet);
                } else {
                    $this->stylePairPage($sheet);
                }
            },

        ];
    }

    private function stylePairPage($sheet): void
    {
        /*
        |--------------------------------------------------------------------------
        | 19 dòng cố định
        |--------------------------------------------------------------------------
        */
        for ($row = 1; $row <= 19; $row++) {

            if ($row == 1 || $row == 11) {

                // Dòng tiêu đề bảng
                $sheet->getRowDimension($row)->setRowHeight(34);

            } elseif ($row == 10) {

                // Dòng trống ngăn cách 2 bảng
                $sheet->getRowDimension($row)->setRowHeight(18);

            } else {

                // Dòng chứa tên học sinh
                $sheet->getRowDimension($row)->setRowHeight(42);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Bảng 1
        |--------------------------------------------------------------------------
        */
        $this->styleTable(
            $sheet,
            1,
            9,
            14
        );

        /*
        |--------------------------------------------------------------------------
        | Bảng 2
        |--------------------------------------------------------------------------
        */
        if (isset($this->tables[1])) {
            $this->styleTable(
                $sheet,
                11,
                19,
                14
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Dòng ngăn cách không có border
        |--------------------------------------------------------------------------
        */
        $sheet->getStyle('A10:C10')
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_NONE,
                    ],
                ],
            ]);
    }

    private function styleSinglePage($sheet): void
    {
        /*
        |--------------------------------------------------------------------------
        | Sheet riêng cho size lớn
        |--------------------------------------------------------------------------
        */
        for ($row = 1; $row <= 19; $row++) {

            if ($row == 1) {

                // Tiêu đề
                $sheet->getRowDimension($row)->setRowHeight(36);

            } else {

                // 18 dòng tên
                $sheet->getRowDimension($row)->setRowHeight(40);
            }
        }

        $this->styleTable(
            $sheet,
            1,
            19,
            15
        );
    }

    private function styleTable(
        $sheet,
        int $startRow,
        int $endRow,
        int $titleSize = 14
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Merge tiêu đề
        |--------------------------------------------------------------------------
        */
        $sheet->mergeCells("A{$startRow}:C{$startRow}");

        $sheet->getStyle("A{$startRow}:C{$startRow}")
            ->getFont()
            ->setBold(true)
            ->setSize($titleSize);

        $sheet->getStyle("A{$startRow}:C{$startRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        /*
        |--------------------------------------------------------------------------
        | Border bảng
        |--------------------------------------------------------------------------
        */
        $sheet->getStyle("A{$startRow}:C{$endRow}")
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                ],
            ]);

        /*
        |--------------------------------------------------------------------------
        | Tên học sinh căn trái
        |--------------------------------------------------------------------------
        */
        $bodyStart = $startRow + 1;

        $sheet->getStyle("A{$bodyStart}:C{$endRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
    }

    private static function getStudentNameStatic($student): string
    {
        if (!empty($student->name)) {
            return $student->name;
        }

        if (!empty($student->student_name)) {
            return $student->student_name;
        }

        if (!empty($student->full_name)) {
            return $student->full_name;
        }

        return '---';
    }

    private static function getSizeOrder($sizeName): int
    {
        $size = strtoupper(trim((string) $sizeName));

        $size = str_replace(
            [' ', '-', '_'],
            '',
            $size
        );

        $orders = [
            'XXS' => 5,
            'XS' => 10,

            'S' => 20,
            'M' => 30,
            'L' => 40,
            'XL' => 50,

            'XXL' => 60,
            '2XL' => 60,

            'XXXL' => 70,
            '3XL' => 70,

            'XXXXL' => 80,
            '4XL' => 80,

            '5XL' => 90,
            '6XL' => 100,

            'FREE' => 999,
            'FREESIZE' => 999,
        ];

        if (isset($orders[$size])) {
            return $orders[$size];
        }

        /*
        |--------------------------------------------------------------------------
        | Size dạng số: 26, 27, 28, 29 hoặc 150, 160...
        |--------------------------------------------------------------------------
        */
        if (is_numeric($size)) {
            return 1000 + (int) $size;
        }

        return 9999;
    }
}