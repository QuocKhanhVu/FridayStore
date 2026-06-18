<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostumeSizeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('costume_sizes')->delete();

        $data = [];

        // S -> 6XL
        $normalSizes = [
            'S', 'M', 'L', 'XL',
            '2XL', '3XL', '4XL', '5XL', '6XL'
        ];

        // Vest, quần
        $vestSizes = [
            '2', '3', '4', '5', '6',
            'XL', '2XL',
            '45', '46', '47', '48'
        ];

        // Áo dài, sơ mi, váy
        $normalCostumes = [
            15, 16, // Áo dài
            19, 20, 21, // Sơ mi
            22, 23 // Váy
        ];

        foreach ($normalCostumes as $costumeId) {
            foreach ($normalSizes as $index => $size) {
                $data[] = [
                    'costume_id' => $costumeId,
                    'size_name' => $size,
                    'display_order' => $index + 1,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Vest và quần
        foreach ([17, 18, 24] as $costumeId) {
            foreach ($vestSizes as $index => $size) {
                $data[] = [
                    'costume_id' => $costumeId,
                    'size_name' => $size,
                    'display_order' => $index + 1,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('costume_sizes')->insert($data);
    }
}