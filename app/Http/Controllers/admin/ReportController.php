<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Rental;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Bộ lọc ngày
        |--------------------------------------------------------------------------
        */
        $from = $request->from;
        $to = $request->to;

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
        | Query đơn thuê theo bộ lọc
        |--------------------------------------------------------------------------
        */
        $rentalQuery = Rental::query()
            ->when($from, function ($query) use ($from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($query) use ($to) {
                $query->whereDate('created_at', '<=', $to);
            });

        /*
        |--------------------------------------------------------------------------
        | Thống kê tổng quan
        |--------------------------------------------------------------------------
        */
        $totalRentals = (clone $rentalQuery)->count();

        $rentingRentals = (clone $rentalQuery)
            ->where('status', 'renting')
            ->count();

        $processingRentals = (clone $rentalQuery)
            ->where('status', 'processing')
            ->count();

        $completedRentals = (clone $rentalQuery)
            ->where('status', 'completed')
            ->count();

        $totalStudents = (clone $rentalQuery)
            ->sum('student_count');

        $totalRevenue = (clone $rentalQuery)
            ->whereIn('status', [
                'renting',
                'processing',
                'completed',
            ])
            ->sum('total_amount');

        $totalInventory = Inventory::sum($quantityTotalColumn);

        $totalRentedInventory = Inventory::sum($quantityRentedColumn);

        $totalBroken = Schema::hasColumn('inventories', 'broken_quantity')
            ? Inventory::sum('broken_quantity')
            : 0;

        $totalLost = Schema::hasColumn('inventories', 'lost_quantity')
            ? Inventory::sum('lost_quantity')
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Báo cáo theo trạng thái đơn
        |--------------------------------------------------------------------------
        */
        $statusReports = [
            [
                'label' => 'Nháp / Chờ chia size',
                'status' => 'draft',
                'count' => (clone $rentalQuery)->where('status', 'draft')->count(),
                'amount' => (clone $rentalQuery)->where('status', 'draft')->sum('total_amount'),
            ],
            [
                'label' => 'Đang thuê',
                'status' => 'renting',
                'count' => (clone $rentalQuery)->where('status', 'renting')->count(),
                'amount' => (clone $rentalQuery)->where('status', 'renting')->sum('total_amount'),
            ],
            [
                'label' => 'Đang xử lý',
                'status' => 'processing',
                'count' => (clone $rentalQuery)->where('status', 'processing')->count(),
                'amount' => (clone $rentalQuery)->where('status', 'processing')->sum('total_amount'),
            ],
            [
                'label' => 'Hoàn thành',
                'status' => 'completed',
                'count' => (clone $rentalQuery)->where('status', 'completed')->count(),
                'amount' => (clone $rentalQuery)->where('status', 'completed')->sum('total_amount'),
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Báo cáo theo studio
        |--------------------------------------------------------------------------
        */
        $studioReports = Rental::select(
                'studio_id',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(student_count) as total_students'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->with('studio')
            ->when($from, function ($query) use ($from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($query) use ($to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->groupBy('studio_id')
            ->orderByDesc('total_amount')
            ->limit(10)
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
            ->limit(10)
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

            $chartLabels[] = 'T' . $date->format('m/Y');

            $chartData[] = Rental::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->whereIn('status', [
                    'renting',
                    'processing',
                    'completed',
                ])
                ->sum('total_amount');
        }

        return view('admin.reports.index', compact(
            'from',
            'to',
            'totalRentals',
            'rentingRentals',
            'processingRentals',
            'completedRentals',
            'totalStudents',
            'totalRevenue',
            'totalInventory',
            'totalRentedInventory',
            'totalBroken',
            'totalLost',
            'statusReports',
            'studioReports',
            'lowStocks',
            'chartLabels',
            'chartData',
            'quantityTotalColumn',
            'quantityRentedColumn',
            'quantityAvailableColumn'
        ));
    }
}