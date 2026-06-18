<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Tự nhận diện tên cột tồn kho
        |--------------------------------------------------------------------------
        */

        $quantityTotalColumn = Schema::hasColumn('inventories', 'quantity_total')
            ? 'quantity_total'
            : 'quantity';

        $quantityRentedColumn = Schema::hasColumn('inventories', 'quantity_rented')
            ? 'quantity_rented'
            : 'rented_quantity';

        $quantityAvailableColumn = Schema::hasColumn('inventories', 'quantity_available')
            ? 'quantity_available'
            : null;

        /*
        |--------------------------------------------------------------------------
        | Card thống kê
        |--------------------------------------------------------------------------
        */

        $totalCostumes = Inventory::sum($quantityTotalColumn);

        $totalRenting = Inventory::sum($quantityRentedColumn);

        $processingOrders = Rental::whereIn('status', [
                'draft',
                'processing',
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Doanh thu tháng này
        |--------------------------------------------------------------------------
        | Không dùng bảng revenues vì database hiện tại chưa có bảng này.
        | Lấy trực tiếp từ rentals.total_amount.
        */

        $lastMonth = now()->subMonth();

        $monthlyRevenue = Rental::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->whereIn('status', [
                'renting',
                'processing',
                'completed',
            ])
            ->sum('total_amount');

        /*
        |--------------------------------------------------------------------------
        | Đơn cần xử lý
        |--------------------------------------------------------------------------
        */

        $pendingRentals = Rental::with([
                'studio',
                'concept',
                'secondConcept',
            ])
            ->whereIn('status', [
                'draft',
                'processing',
            ])
            ->latest()
            ->limit(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Cảnh báo tồn kho thấp
        |--------------------------------------------------------------------------
        */

        $lowStockQuery = Inventory::with([
                'costume',
                'size',
            ]);

        if ($quantityAvailableColumn) {
            $lowStockQuery
                ->where($quantityAvailableColumn, '<=', 5)
                ->orderBy($quantityAvailableColumn);
        } else {
            $lowStockQuery
                ->whereRaw("({$quantityTotalColumn} - {$quantityRentedColumn}) <= 5")
                ->orderByRaw("({$quantityTotalColumn} - {$quantityRentedColumn}) ASC");
        }

        $lowStocks = $lowStockQuery
            ->limit(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Biểu đồ doanh thu 6 tháng gần nhất
        |--------------------------------------------------------------------------
        */

        $chartLabels = [];

        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = now()->subMonths($i);

            $chartLabels[] = 'T' . $date->format('m');

            $chartData[] = Rental::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->whereIn('status', [
                    'renting',
                    'processing',
                    'completed',
                ])
                ->sum('total_amount');
        }

        return view('admin.dashboard.index', compact(
            'totalCostumes',
            'totalRenting',
            'processingOrders',
            'monthlyRevenue',
            'pendingRentals',
            'lowStocks',
            'chartLabels',
            'chartData',
            'quantityTotalColumn',
            'quantityRentedColumn',
            'quantityAvailableColumn'
        ));
    }
}