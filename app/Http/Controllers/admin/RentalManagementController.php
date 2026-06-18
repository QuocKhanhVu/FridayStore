<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Models\RentalStudentSize;
use App\Models\Inventory;
use App\Models\RentalRevenue;

class RentalManagementController extends Controller
{
   public function index(Request $request)
    {
        $data = Rental::query()

            ->whereIn('status', [
                'renting',
                'processing'
            ])

            ->latest()

            ->paginate(12);

        return view(
            'admin.rental-management.index',
            compact('data')
        );
    }

    public function updateStatus(
    Request $request,
    Rental $rental
    )
    {
        $request->validate([

            'status' => 'required',

            'processing_note' =>
                'nullable|string|max:1000'

        ]);

        $oldStatus = $rental->status;

        $newStatus = $request->status;

        /*
        |--------------------------------------------------------------------------
        | TRẢ KHO KHI RENTING -> COMPLETED
        |--------------------------------------------------------------------------
        */
        if (
            $oldStatus === 'renting'
            &&
            $newStatus === 'completed'
        ) {

            $studentIds = $rental
                ->students
                ->pluck('id');

            $sizes = RentalStudentSize::whereIn(
                'rental_student_id',
                $studentIds
            )->get();

            foreach ($sizes as $size) {

                if (!$size->costume_size_id) {
                    continue;
                }

                $inventory = Inventory::where(
                    'costume_id',
                    $size->costume_id
                )
                ->where(
                    'costume_size_id',
                    $size->costume_size_id
                )
                ->first();

                if (
                    $inventory
                    &&
                    $inventory->rented_quantity > 0
                ) {
                    $inventory->decrement(
                        'rented_quantity',
                        1
                    );
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | THUÊ LẠI KHI COMPLETED -> RENTING
        |--------------------------------------------------------------------------
        */
        if (
            $oldStatus === 'completed'
            &&
            $newStatus === 'renting'
        ) {

            $studentIds = $rental
                ->students
                ->pluck('id');

            $sizes = RentalStudentSize::whereIn(
                'rental_student_id',
                $studentIds
            )->get();

            foreach ($sizes as $size) {

                if (!$size->costume_size_id) {
                    continue;
                }

                $inventory = Inventory::where(
                    'costume_id',
                    $size->costume_id
                )
                ->where(
                    'costume_size_id',
                    $size->costume_size_id
                )
                ->first();

                if ($inventory) {
                    $inventory->increment(
                        'rented_quantity',
                        1
                    );
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DỮ LIỆU UPDATE CƠ BẢN
        |--------------------------------------------------------------------------
        */
        $updateData = [

            'status' => $newStatus,

            'processing_note' =>
                $newStatus === 'processing'
                    ? $request->processing_note
                    : null

        ];

        /*
        `|--------------------------------------------------------------------------
        | TÍNH DOANH THU KHI CHUYỂN SANG ĐANG THUÊ / HOÀN THÀNH
        |--------------------------------------------------------------------------
        */
        if (in_array($newStatus, ['renting', 'completed'])) {

        $rental->load([
            'concept',
            'secondConcept'
        ]);

        $studentCount = $rental->students()->count();

        RentalRevenue::where(
            'rental_id',
            $rental->id
        )->delete();

        $concepts = collect();

        if ($rental->concept) {
            $concepts->push($rental->concept);
        }

        if ($rental->secondConcept) {
            $concepts->push($rental->secondConcept);
        }

        $totalAmount = 0;
        $discountAmount = 0;
        $finalAmount = 0;

        foreach ($concepts as $concept) {

            $price = $concept->price ?? 0;

            $discountPercent =
                $concept->discount_percent ?? 0;

            $conceptTotal =
                $studentCount * $price;

            $conceptDiscount =
                $conceptTotal * $discountPercent / 100;

            $conceptFinal =
                $conceptTotal - $conceptDiscount;

            RentalRevenue::create([

                'rental_id' =>
                    $rental->id,

                'concept_id' =>
                    $concept->id,

                'student_count' =>
                    $studentCount,

                'price' =>
                    $price,

                'discount_percent' =>
                    $discountPercent,

                'total_amount' =>
                    $conceptTotal,

                'discount_amount' =>
                    $conceptDiscount,

                'final_amount' =>
                    $conceptFinal,

            ]);

            $totalAmount += $conceptTotal;
            $discountAmount += $conceptDiscount;
            $finalAmount += $conceptFinal;
        }

        $updateData = array_merge($updateData, [

            'student_count' =>
                $studentCount,

            'concept_price' =>
                $concepts->sum('price'),

            'discount_percent' =>
                $totalAmount > 0
                    ? round(($discountAmount / $totalAmount) * 100, 2)
                    : 0,

            'discount_amount' =>
                $discountAmount,

            'total_amount' =>
                $totalAmount,

            'final_amount' =>
                $finalAmount,

        ]);
    }
        $rental->update($updateData);

        return back()->with(
            'success',
            'Cập nhật thành công'
        );
    }
    public function updateStudentSize(
    Request $request,
    $id
    ) {
        $studentSize = RentalStudentSize::findOrFail($id);

        if ($request->costume_size_id == 0) {

            $studentSize->update([
                'costume_size_id' => null
            ]);

        } else {

            $request->validate([
                'costume_size_id' =>
                    'exists:costume_sizes,id'
            ]);

            $studentSize->update([
                'costume_size_id' =>
                    $request->costume_size_id
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }
    public function show(Rental $rental)
    {
        $rental->loadCount('students');
        $rental->load([

            'studio',

            'concept',

            'secondConcept',

            'extraCostume',

            'graduation',

            'femaleAccessory',

            'maleAccessory',

            'students.sizes.costume',

            'students.sizes.size',

        ]);

        return view(
            'admin.rental-history.show',
            compact('rental')
        );
    }
}