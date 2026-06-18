<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RevenueExport;
use App\Exports\RevenuesExport;
use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Studio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::query()
            ->with([
                'studio',
                'concept',
                'secondConcept',
                'revenues.concept',
            ])
            ->whereIn('status', [
                'renting',
                'processing',
                'completed',
            ]);

        if ($request->filled('from')) {
            $query->whereDate(
                'shooting_date',
                '>=',
                $request->from
            );
        }

        if ($request->filled('to')) {
            $query->whereDate(
                'shooting_date',
                '<=',
                $request->to
            );
        }

        if ($request->filled('studio_id')) {
            $query->where(
                'studio_id',
                $request->studio_id
            );
        }

        $summaryRentals = (clone $query)->get();

        $totalAmount = $summaryRentals->sum(function ($rental) {
            return $rental->revenues->sum('total_amount');
        });

        $totalDiscount = $summaryRentals->sum(function ($rental) {
            return $rental->revenues->sum('discount_amount');
        });

        $finalRevenue = $summaryRentals->sum(function ($rental) {
            return $rental->revenues->sum('final_amount');
        });

        $totalOrders = $summaryRentals->count();

        $totalStudents = $summaryRentals->sum('student_count');

        $data = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $studios = Studio::query()
            ->orderBy('name')
            ->get();

        return view(
            'admin.revenues.index',
            compact(
                'data',
                'studios',
                'totalAmount',
                'totalDiscount',
                'finalRevenue',
                'totalOrders',
                'totalStudents'
            )
        );
    }
    public function export(Request $request)
    {
        return Excel::download(
            new RevenuesExport($request->only([
                'from',
                'to',
                'studio_id',
            ])),
            'doanh-thu-' . now()->format('d-m-Y-H-i-s') . '.xlsx'
        );
    }
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $rental = Rental::with([
                'students.assignedSizes',
            ])->findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | Nếu có bảng revenues thì xóa doanh thu chi tiết trước
            |--------------------------------------------------------------------------
            */
            if (method_exists($rental, 'revenues')) {
                $rental->revenues()->delete();
            }

            /*
            |--------------------------------------------------------------------------
            | Xóa dữ liệu chia size của học sinh
            |--------------------------------------------------------------------------
            */
            foreach ($rental->students as $student) {
                $student->assignedSizes()->delete();
            }

            /*
            |--------------------------------------------------------------------------
            | Xóa học sinh trong đơn
            |--------------------------------------------------------------------------
            */
            $rental->students()->delete();

            /*
            |--------------------------------------------------------------------------
            | Xóa đơn thuê
            |--------------------------------------------------------------------------
            */
            $rental->delete();

            DB::commit();

            return redirect()
                ->route('admin.revenues.index')
                ->with('success', 'Xóa đơn doanh thu thành công.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Không thể xóa: ' . $e->getMessage());
        }
    }
}