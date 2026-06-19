<?php

namespace Database\Seeders;

use App\Models\CostumeSize;
use App\Models\Inventory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('inventories')->delete();

        $oldWarehouseId = DB::table('users')
            ->where('email', 'oldwarehouse@fridaystore.vn')
            ->value('id');

        $data = [];

        $sizes = CostumeSize::all();

        foreach ($sizes as $size) {

            $data[] = [
                'user_id' => $oldWarehouseId,
                'costume_id' => $size->costume_id,
                'costume_size_id' => $size->id,
                'quantity' => 100,
                'rented_quantity' => 0,
                'broken_quantity' => 0,
                'lost_quantity' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Inventory::insert($data);
    }
}