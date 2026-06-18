<?php

namespace App\Http\Controllers\admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Costume;
use App\Models\Inventory;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InventoryDamageController extends Controller
{
    public function create()
    {
        $costumes = Costume::with('sizes')
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $rentals = Rental::with('studio')
            ->whereIn('status', [
                'renting',
                'processing',
                'completed',
            ])
            ->latest()
            ->limit(100)
            ->get();

        return view('admin.warehouse.inventory.damage.create', compact(
            'costumes',
            'rentals'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'costume_id' => [
                'required',
                'exists:costumes,id',
            ],
            'costume_size_id' => [
                'nullable',
                'exists:costume_sizes,id',
            ],
            'type' => [
                'required',
                'in:broken,lost',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'rental_id' => [
                'nullable',
                'exists:rentals,id',
            ],
            'note' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'costume_id.required' => 'Vui lòng chọn trang phục.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
            'type.required' => 'Vui lòng chọn loại báo lỗi.',
        ]);

        DB::beginTransaction();

        try {
            $quantityTotalColumn = Schema::hasColumn('inventories', 'quantity_total')
                ? 'quantity_total'
                : 'quantity';

            $quantityRentedColumn = Schema::hasColumn('inventories', 'quantity_rented')
                ? 'quantity_rented'
                : 'rented_quantity';

            $quantityAvailableColumn = Schema::hasColumn('inventories', 'quantity_available')
                ? 'quantity_available'
                : null;

            $inventory = Inventory::where('costume_id', $request->costume_id)
                ->where(function ($query) use ($request) {
                    if ($request->costume_size_id) {
                        $query->where('costume_size_id', $request->costume_size_id);
                    } else {
                        $query->whereNull('costume_size_id');
                    }
                })
                ->lockForUpdate()
                ->first();

            if (!$inventory) {
                return back()
                    ->withInput()
                    ->with('error', 'Không tìm thấy tồn kho của trang phục này.');
            }

            $total = $inventory->{$quantityTotalColumn} ?? 0;
            $rented = $inventory->{$quantityRentedColumn} ?? 0;

            if ($quantityAvailableColumn) {
                $available = $inventory->{$quantityAvailableColumn} ?? 0;
            } else {
                $available = $total - $rented;
            }

            if ($request->quantity > $available) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Không thể trừ quá số lượng còn trong kho. Hiện còn: ' . $available
                    );
            }

            $inventory->{$quantityTotalColumn} = $total - $request->quantity;

            if ($quantityAvailableColumn) {
                $inventory->{$quantityAvailableColumn} = $available - $request->quantity;
            }

            if ($request->type == 'broken') {
                $inventory->broken_quantity = ($inventory->broken_quantity ?? 0) + $request->quantity;
            }

            if ($request->type == 'lost') {
                $inventory->lost_quantity = ($inventory->lost_quantity ?? 0) + $request->quantity;
            }

            $inventory->save();

            DB::commit();

            $message = $request->type == 'broken'
                ? 'Đã báo hỏng và trừ kho thành công.'
                : 'Đã báo mất và trừ kho thành công.';

            return redirect()
                ->route('admin.inventory.damage.create')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}