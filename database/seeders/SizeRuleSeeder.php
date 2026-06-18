<?php

namespace Database\Seeders;

use App\Models\CostumeSize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeRuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('size_rules')->delete();

        $rules = [];

        // Quy tắc size dùng chung cho S -> 6XL
        $normalRules = [
            'S'   => [150, 155, 40, 45],
            'M'   => [156, 160, 46, 50],
            'L'   => [161, 165, 51, 55],
            'XL'  => [166, 170, 56, 60],
            '2XL' => [171, 175, 61, 65],
            '3XL' => [176, 180, 66, 70],
            '4XL' => [181, 185, 71, 75],
            '5XL' => [186, 190, 76, 80],
            '6XL' => [191, 200, 81, 100],
        ];

        // Quy tắc vest, quần
        $vestRules = [
            '2'   => [150, 155, 40, 45],
            '3'   => [156, 160, 46, 50],
            '4'   => [161, 165, 51, 55],
            '5'   => [166, 170, 56, 60],
            '6'   => [171, 175, 61, 65],
            'XL'  => [176, 180, 66, 70],
            '2XL' => [181, 185, 71, 75],
            '45'  => [165, 170, 55, 60],
            '46'  => [171, 175, 61, 66],
            '47'  => [176, 180, 67, 72],
            '48'  => [181, 190, 73, 85],
        ];

        $sizes = CostumeSize::with('costume')->get();

        foreach ($sizes as $size) {

            $costume = $size->costume;

            if (!$costume) {
                continue;
            }

            $rule = null;
            $gender = $costume->gender;

            // Áo dài, váy, sơ mi
            if (in_array($size->size_name, array_keys($normalRules))) {
                $rule = $normalRules[$size->size_name];

                // Sơ mi dùng chung
                if (in_array($costume->id, [19, 20, 21])) {
                    $gender = 'unisex';
                }
            }

            // Vest, quần
            if (in_array($size->size_name, array_keys($vestRules))) {
                $rule = $vestRules[$size->size_name];
            }

            if (!$rule) {
                continue;
            }

            $rules[] = [
                'costume_size_id' => $size->id,
                'height_from'     => $rule[0],
                'height_to'       => $rule[1],
                'weight_from'     => $rule[2],
                'weight_to'       => $rule[3],
                'gender'          => $gender,
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        DB::table('size_rules')->insert($rules);
    }
}