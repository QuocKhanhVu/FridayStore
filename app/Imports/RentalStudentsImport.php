<?php

namespace App\Imports;

use App\Models\Rental;
use App\Models\RentalStudent;

use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Collection;

class RentalStudentsImport implements ToCollection
{
    protected $rental;

    protected $startRow;

    protected $nameColumn;

    protected $genderColumn;

    protected $heightColumn;

    protected $weightColumn;

    public function __construct(
        Rental $rental,
        $startRow,
        $nameColumn,
        $genderColumn,
        $heightColumn,
        $weightColumn
    ) {

        $this->rental = $rental;

        $this->startRow = $startRow;

        $this->nameColumn = strtoupper($nameColumn);

        $this->genderColumn = strtoupper($genderColumn);

        $this->heightColumn = strtoupper($heightColumn);

        $this->weightColumn = strtoupper($weightColumn);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            $excelRow = $index + 1;

            if ($excelRow < $this->startRow) {
                continue;
            }
            $name = $row[
                $this->columnToIndex(
                    $this->nameColumn
                )
            ] ?? null;

            if (!$name) {
                continue;
            }

            RentalStudent::create([

                'rental_id' => $this->rental->id,

                'full_name' => trim($name),

                'gender' => $this->convertGender(

                    $row[
                        $this->columnToIndex(
                            $this->genderColumn
                        )
                    ] ?? null

                ),

                'height' => $row[
                    $this->columnToIndex(
                        $this->heightColumn
                    )
                ] ?? null,

                'weight' => $row[
                    $this->columnToIndex(
                        $this->weightColumn
                    )
                ] ?? null,

            ]);
        }
    }

    private function columnToIndex($column)
    {
        return ord($column) - 65;
    }

    private function convertGender($gender)
    {
        $gender = strtolower(trim($gender));

        if (
            $gender == 'nam'
            || $gender == 'male'
        ) {
            return 'male';
        }

        if (
            $gender == 'nữ'
            || $gender == 'nu'
            || $gender == 'female'
        ) {
            return 'female';
        }

        return null;
    }
}