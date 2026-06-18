<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CostumeCategory;

class CostumeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Áo',
            'Quần',
            'Váy',
            'Áo dài',
            'Vest',
            'Phụ kiện',
        ];

        foreach ($categories as $category) {

            CostumeCategory::firstOrCreate([
                'name' => $category
            ]);
        }
    }
}