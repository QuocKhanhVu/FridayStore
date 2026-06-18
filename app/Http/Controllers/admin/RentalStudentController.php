<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RentalSizeResultExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rental\ImportStudentRequest;
use App\Imports\RentalStudentsImport;
use App\Models\Inventory;
use App\Models\Rental;
use App\Models\RentalStudentSize;
use App\Models\SizeRule;
use Maatwebsite\Excel\Facades\Excel;

class RentalStudentController extends Controller
{
    /**
     * Form import học sinh.
     */
    public function create(Rental $rental)
    {
        return view(
            'admin.rentals.import_students',
            compact('rental')
        );
    }

    /**
     * Import danh sách học sinh.
     */
    public function store(
        ImportStudentRequest $request,
        Rental $rental
    ) {
        $rental->students()->delete();

        Excel::import(
            new RentalStudentsImport(
                $rental,
                $request->start_row,
                $request->name_column,
                $request->gender_column,
                $request->height_column,
                $request->weight_column
            ),
            $request->file('file')
        );

        return redirect()
            ->route(
                'admin.rentals.students.index',
                $rental
            )
            ->with(
                'success',
                'Import danh sách học sinh thành công.'
            );
    }

    /**
     * Danh sách học sinh.
     */
    public function index(Rental $rental)
    {
        $students = $rental
            ->students()
            ->paginate(50);

        return view(
            'admin.rentals.students.index',
            compact(
                'rental',
                'students'
            )
        );
    }

    /**
     * Chia size tự động.
     */
    public function autoSize(Rental $rental)
    {
        $rental->load([
            'concept.costumes.sizes',
            'secondConcept.costumes.sizes',
            'extraCostume.sizes',
            'students',
        ]);

        $costumes = $this->getSizeableCostumes($rental);

        if ($costumes->isEmpty()) {
            return back()->with(
                'error',
                'Đơn thuê chưa có trang phục nào cần chia size.'
            );
        }

        RentalStudentSize::whereIn(
            'rental_student_id',
            $rental->students->pluck('id')
        )->delete();

        foreach ($rental->students as $student) {

            foreach ($costumes as $costume) {

                if (!$this->canAssignCostumeToStudent($costume, $student)) {
                    continue;
                }

                $rule = $this->findBestSizeRule(
                    $costume,
                    $student
                );

                if (!$rule) {
                    continue;
                }

                RentalStudentSize::create([
                    'rental_student_id' => $student->id,
                    'costume_id' => $costume->id,
                    'costume_size_id' => $rule->costume_size_id,
                ]);
            }
        }

        return redirect()
            ->route(
                'admin.rentals.students.size-result',
                $rental
            )
            ->with(
                'success',
                'Chia size tự động thành công.'
            );
    }

    /**
     * Kết quả chia size.
     */
    public function sizeResult(Rental $rental)
    {
        $rental->load([
            'concept.costumes.sizes',
            'secondConcept.costumes.sizes',
            'extraCostumes.sizes',
            'students',
        ]);

        $students = $rental
            ->students()
            ->with([
                'sizes.size',
                'sizes.costume.sizes',
            ])
            ->get();

        return view(
            'admin.rentals.students.size_result',
            compact(
                'rental',
                'students'
            )
        );
    }

    /**
     * Xuất kết quả chia size và chuyển đơn sang đang thuê.
     */
    // public function export(Rental $rental)
    // {
    //     if ($rental->status !== 'renting') {

    //         $studentIds = $rental->students->pluck('id');

    //         $sizes = RentalStudentSize::whereIn(
    //             'rental_student_id',
    //             $studentIds
    //         )->get();

    //         foreach ($sizes as $size) {

    //             if (!$size->costume_size_id) {
    //                 continue;
    //             }

    //             Inventory::where(
    //                 'costume_id',
    //                 $size->costume_id
    //             )
    //                 ->where(
    //                     'costume_size_id',
    //                     $size->costume_size_id
    //                 )
    //                 ->increment(
    //                     'rented_quantity',
    //                     1
    //                 );
    //         }

    //         $rental->update([
    //             'status' => 'renting',
    //         ]);
    //     }

    //     return Excel::download(
    //         new RentalSizeResultExport($rental),
    //         'chia-size-' . $rental->class_name . '.xlsx'
    //     );
    // }
public function export(Rental $rental)
{
    /*
    |--------------------------------------------------------------------------
    | Load dữ liệu cần dùng
    |--------------------------------------------------------------------------
    */
    $rental->load([
        'studio',
        'students',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Nếu đơn chưa chuyển sang đang thuê thì cập nhật tồn kho
    |--------------------------------------------------------------------------
    */
    if ($rental->status !== 'renting') {

        $studentIds = $rental->students->pluck('id');

        $sizes = RentalStudentSize::whereIn(
            'rental_student_id',
            $studentIds
        )->get();

        foreach ($sizes as $size) {

            if (!$size->costume_size_id) {
                continue;
            }

            Inventory::where(
                'costume_id',
                $size->costume_id
            )
                ->where(
                    'costume_size_id',
                    $size->costume_size_id
                )
                ->increment(
                    'rented_quantity',
                    1
                );
        }

        $rental->update([
            'status' => 'renting',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Tạo tên file:
    | Tên Studio + ngày chụp + tên lớp + tên trường
    |--------------------------------------------------------------------------
    */
    $studioName = $rental->studio->name ?? 'Studio';

    $shootingDate = $rental->shooting_date
        ? \Carbon\Carbon::parse($rental->shooting_date)->format('d.m')
        : 'no-date';

    $className = $rental->class_name ?? 'Lop';

    $schoolName = $rental->school_name ?? 'Truong';

    $fileName = $studioName
        .' '. $shootingDate
        . ' ' . $className
        . ' ' . $schoolName
        . '.xlsx';

    /*
    |--------------------------------------------------------------------------
    | Xóa ký tự không hợp lệ trong tên file Windows
    |--------------------------------------------------------------------------
    */
    $fileName = preg_replace('/[\/\\\\:*?"<>|]/', '-', $fileName);

    return Excel::download(
        new RentalSizeResultExport($rental),
        $fileName
    );
}
    /**
     * Gom trang phục từ Concept 1 + Concept 2 + Trang phục thêm.
     */
    private function getSizeableCostumes(Rental $rental)
    {
        $costumes = collect();

        if ($rental->concept) {
            $costumes = $costumes->merge(
                $rental->concept->costumes
            );
        }

        if ($rental->secondConcept) {
            $costumes = $costumes->merge(
                $rental->secondConcept->costumes
            );
        }

        if ($rental->extraCostumes) {
            $costumes = $costumes->merge(
                $rental->extraCostumes
            );
        }

        return $costumes
            ->unique('id')
            ->filter(function ($costume) {
                return (int) $costume->has_size === 1;
            })
            ->values();
    }

    /**
     * Đồ nam chỉ chia cho nam, đồ nữ chỉ chia cho nữ, unisex chia cho cả hai.
     */
    private function canAssignCostumeToStudent($costume, $student): bool
    {
        if ($costume->gender === 'unisex') {
            return true;
        }

        return $costume->gender === $student->gender;
    }

    /**
     * Tìm size rule khớp cả chiều cao và cân nặng.
     * Không fallback chỉ theo chiều cao để tránh trường hợp cao thấp nhưng cân nặng quá lớn bị ép size sai.
     */
    private function findMatchedSizeRule($costume, $student): ?SizeRule
    {
        return SizeRule::query()
            ->whereHas('costumeSize', function ($query) use ($costume) {
                $query->where(
                    'costume_id',
                    $costume->id
                );
            })
            ->where(function ($query) use ($student) {
                $query->whereNull('height_from')
                    ->orWhere('height_from', '<=', $student->height);
            })
            ->where(function ($query) use ($student) {
                $query->whereNull('height_to')
                    ->orWhere('height_to', '>=', $student->height);
            })
            ->where(function ($query) use ($student) {
                $query->whereNull('weight_from')
                    ->orWhere('weight_from', '<=', $student->weight);
            })
            ->where(function ($query) use ($student) {
                $query->whereNull('weight_to')
                    ->orWhere('weight_to', '>=', $student->weight);
            })
            ->first();
    }

    private function findBestSizeRule($costume, $student)
    {
        $rules = SizeRule::query()
            ->whereHas('costumeSize', function ($query) use ($costume) {
                $query->where('costume_id', $costume->id);
            })
            ->get();

        if ($rules->isEmpty()) {
            return null;
        }

        $exactRule = $rules->first(function ($rule) use ($student) {
            return
                $student->height >= $rule->height_from &&
                $student->height <= $rule->height_to &&
                $student->weight >= $rule->weight_from &&
                $student->weight <= $rule->weight_to;
        });

        if ($exactRule) {
            return $exactRule;
        }

        return $rules
            ->map(function ($rule) use ($student) {

                $heightScore = 0;

                if ($student->height < $rule->height_from) {
                    $heightScore = $rule->height_from - $student->height;
                } elseif ($student->height > $rule->height_to) {
                    $heightScore = $student->height - $rule->height_to;
                }

                $weightScore = 0;

                if ($student->weight < $rule->weight_from) {
                    $weightScore = $rule->weight_from - $student->weight;
                } elseif ($student->weight > $rule->weight_to) {
                    $weightScore = $student->weight - $rule->weight_to;
                }

                $rule->score =
                    ($heightScore * 1)
                    +
                    ($weightScore * 2);

                return $rule;
            })
            ->sortBy('score')
            ->first();
    }
}
