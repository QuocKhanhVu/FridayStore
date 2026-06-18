<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RentalSizeResultExport;
use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\DB;
class RentalHistoryController extends Controller
{
    public function history(Request $request)
    {
        $data = Rental::with([
                'concept',
                'secondConcept',
                'extraCostume',
                'studio',
            ])
            ->withCount('students')
            ->where('status', 'completed')
            ->when($request->keyword, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('code', 'like', '%' . $request->keyword . '%')
                        ->orWhere('school_name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('class_name', 'like', '%' . $request->keyword . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.rental-history.index',
            compact('data')
        );
    }

    public function export(Rental $rental)
    {
        return Excel::download(
            new RentalSizeResultExport($rental),
            'chia-size-' . $rental->class_name . '.xlsx'
        );
    }
    public function destroy($id)
{
    DB::beginTransaction();

    try {
        $rental = Rental::with([
            'students.assignedSizes',
            'extraItems',
        ])->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Chỉ cho xóa đơn đã hoàn thành
        |--------------------------------------------------------------------------
        */
        if ($rental->status !== 'completed') {
            return redirect()
                ->back()
                ->with('error', 'Chỉ được xóa đơn đã hoàn thành.');
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
        | Xóa danh sách học sinh
        |--------------------------------------------------------------------------
        */
        $rental->students()->delete();

        /*
        |--------------------------------------------------------------------------
        | Xóa phụ kiện / phát sinh nếu có
        |--------------------------------------------------------------------------
        */
        if (method_exists($rental, 'extraItems')) {
            $rental->extraItems()->delete();
        }

        /*
        |--------------------------------------------------------------------------
        | Xóa doanh thu nếu hệ thống có bảng revenues
        |--------------------------------------------------------------------------
        */
        if (method_exists($rental, 'revenues')) {
            $rental->revenues()->delete();
        }

        /*
        |--------------------------------------------------------------------------
        | Xóa đơn thuê
        |--------------------------------------------------------------------------
        */
        $rental->delete();

        DB::commit();

        return redirect()
            ->route('admin.rental-history.history')
            ->with('success', 'Xóa đơn khỏi lịch sử thành công.');

    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()
            ->back()
            ->with('error', 'Không thể xóa đơn: ' . $e->getMessage());
    }
}
}
