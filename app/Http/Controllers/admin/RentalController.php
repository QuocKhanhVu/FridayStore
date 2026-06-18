<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rental\StoreRentalRequest;
use App\Http\Requests\Rental\UpdateRentalRequest;
use App\Models\Concept;
use App\Models\Costume;
use App\Models\Rental;
use App\Models\Studio;

class RentalController extends Controller
{
    /**
     * Danh sách đơn nháp.
     */
    public function index()
    {
        $data = Rental::with([
                'studio',
                'concept',
                'secondConcept',
                'extraCostume',
            ])
            ->withCount('students')
            ->where('status', 'draft')
            ->latest()
            ->paginate(15);

        return view(
            'admin.rentals.index',
            compact('data')
        );
    }

    /**
     * Form tạo đơn thuê.
     */
    public function create()
    {
        $studios = Studio::orderBy('name')->get();

        $concepts = Concept::with('costumes')
            ->orderBy('name')
            ->get();

        $extraCostumes = Costume::query()
            ->where('has_size', true)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        $costumes_code_CN = Costume::query()
            ->where('has_size', false)
            ->where(function ($query) {
                $query->where('code', 'like', '%CN%')
                    ->orWhere('name', 'like', '%cử nhân%')
                    ->orWhere('name', 'like', '%cu nhan%');
            })
            ->orderBy('name')
            ->get();

        $costumes_code_NO = Costume::query()
            ->where('has_size', false)
            ->where(function ($query) {
                $query->where('code', 'like', '%NO%')
                    ->orWhere('name', 'like', '%nơ%')
                    ->orWhere('name', 'like', '%no%');
            })
            ->orderBy('name')
            ->get();

        $costumes_code_CV = Costume::query()
            ->where('has_size', false)
            ->where(function ($query) {
                $query->where('code', 'like', '%CV%')
                    ->orWhere('name', 'like', '%cà vạt%')
                    ->orWhere('name', 'like', '%cavat%');
            })
            ->orderBy('name')
            ->get();

        return view(
            'admin.rentals.create',
            compact(
                'studios',
                'concepts',
                'extraCostumes',
                'costumes_code_CN',
                'costumes_code_NO',
                'costumes_code_CV'
            )
        );
    }

    /**
     * Lưu đơn thuê.
     */
    public function store(StoreRentalRequest $request)
    {
        $rental=Rental::create([
            'code' => 'DH' . now()->format('YmdHis'),
            'studio_id' => $request->studio_id,
            'concept_id' => $request->concept_id,
            'second_concept_id' => $request->second_concept_id,
            
            'graduation_costume_id' => $request->graduation_costume_id,
            'female_accessory_id' => $request->female_accessory_id,
            'male_accessory_id' => $request->male_accessory_id,
            'school_name' => $request->school_name,
            'class_name' => $request->class_name,
            'shooting_date' => $request->shooting_date,
            'rental_date' => $request->rental_date,
            'return_date' => $request->return_date,
            'note' => $request->note,
            'status' => 'draft',
        ]);
        $rental->extraCostumes()->sync(
            $request->extra_costume_ids ?? []
        );
        return redirect()
            ->route('admin.rentals.index')
            ->with(
                'success',
                'Tạo đơn thuê thành công.'
            );
    }

    /**
     * Form sửa.
     */
    public function edit(Rental $rental)
    {
        $studios = Studio::orderBy('name')->get();

        $concepts = Concept::with('costumes')
            ->orderBy('name')
            ->get();

        $extraCostumes = Costume::query()
            ->where('has_size', true)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        $costumes_code_CN = Costume::query()
            ->where('has_size', false)
            ->where(function ($query) {
                $query->where('code', 'like', '%CN%')
                    ->orWhere('name', 'like', '%cử nhân%')
                    ->orWhere('name', 'like', '%cu nhan%');
            })
            ->orderBy('name')
            ->get();

        $costumes_code_NO = Costume::query()
            ->where('has_size', false)
            ->where(function ($query) {
                $query->where('code', 'like', '%NO%')
                    ->orWhere('name', 'like', '%nơ%')
                    ->orWhere('name', 'like', '%no%');
            })
            ->orderBy('name')
            ->get();

        $costumes_code_CV = Costume::query()
            ->where('has_size', false)
            ->where(function ($query) {
                $query->where('code', 'like', '%CV%')
                    ->orWhere('name', 'like', '%cà vạt%')
                    ->orWhere('name', 'like', '%cavat%');
            })
            ->orderBy('name')
            ->get();

        return view(
            'admin.rentals.edit',
            compact(
                'rental',
                'studios',
                'concepts',
                'extraCostumes',
                'costumes_code_CN',
                'costumes_code_NO',
                'costumes_code_CV'
            )
        );
    }

    /**
     * Cập nhật đơn thuê.
     */
    public function update(
        UpdateRentalRequest $request,
        Rental $rental
    ) {
        $rental->update(
            $request->validated()
        );

        return redirect()
            ->route('admin.rentals.index')
            ->with(
                'success',
                'Cập nhật thành công.'
            );
    }

    /**
     * Xóa đơn thuê.
     */
    public function destroy(Rental $rental)
    {
        $rental->delete();

        return back()->with(
            'success',
            'Xóa đơn thuê thành công.'
        );
    }
    /**
     * API lấy trang phục theo nhóm cũ.
     * Giữ lại để tránh lỗi nếu view/route cũ còn gọi ajax.
     */
    public function getCostumes(\Illuminate\Http\Request $request)
    {
        $query = Costume::query();

        if ($request->type === 'graduation') {
            $query->where('has_size', false)
                ->where(function ($q) {
                    $q->where('code', 'like', '%CN%')
                        ->orWhere('name', 'like', '%cử nhân%')
                        ->orWhere('name', 'like', '%cu nhan%');
                });
        }

        if ($request->type === 'female_accessory') {
            $query->where('has_size', false)
                ->where(function ($q) {
                    $q->where('code', 'like', '%NO%')
                        ->orWhere('name', 'like', '%nơ%')
                        ->orWhere('name', 'like', '%no%');
                });
        }

        if ($request->type === 'male_accessory') {
            $query->where('has_size', false)
                ->where(function ($q) {
                    $q->where('code', 'like', '%CV%')
                        ->orWhere('name', 'like', '%cà vạt%')
                        ->orWhere('name', 'like', '%cavat%');
                });
        }

        return response()->json(
            $query->orderBy('name')->get(['id', 'name'])
        );
    }

}
