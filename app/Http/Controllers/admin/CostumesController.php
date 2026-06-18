<?php

namespace App\Http\Controllers\admin;

use App\Exports\CostumesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Costume\UpdateCostumeRequest;
use App\Http\Requests\StoreCostumeRequest;
use App\Models\Costume;
use App\Models\CostumeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CostumesController extends Controller
{
    public function index(Request $request)
        {
            $costumes = Costume::with('category')

                ->when($request->keyword, function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->keyword . '%');
                })

                ->when($request->gender, function ($query) use ($request) {
                    $query->where('gender', $request->gender);
                })

                ->when($request->status !== null && $request->status !== '', function ($query) use ($request) {
                    $query->where('status', $request->status);
                })

                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view('admin.warehouse.costumes.index', compact('costumes'));
        }
    public function export(Request $request)
        {
            return Excel::download(
                new CostumesExport(
                    $request->keyword,
                    $request->gender,
                    $request->status
                ),
                'danh-sach-trang-phuc.xlsx'
            );
        }
    public function create(){
        $categories = CostumeCategory::where('status', 1)->get();
        return view('admin.warehouse.costumes.create',compact('categories'));
    }


    public function store(StoreCostumeRequest $request)
    {
        DB::beginTransaction();

            try {

                $imagePath = null;

                if ($request->hasFile('image')) {

                    $imagePath = $request
                        ->file('image')
                        ->store('costumes', 'public');
                }

                Costume::create([
                    'category_id'   => $request->category_id,
                    'code'          => $request->code,
                    'name'          => $request->name,
                    'gender'        => $request->gender,
                    'has_size'      => $request->has_size,
                    'rental_price'  => $request->rental_price,
                    'image'         => $imagePath,
                    'description'   => $request->description,
                    'status'        => $request->status,
                   
                ]);

                DB::commit();

                return redirect()
                    ->route('admin.costumes.index')
                    ->with(
                        'success',
                        'Thêm trang phục thành công.'
                    );

            } catch (\Exception $e) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Có lỗi xảy ra: ' . $e->getMessage()
                    );
            }
    }
    public function edit(Costume $costume)
    {
        $categories = CostumeCategory::all();

        return view(
            'admin.warehouse.costumes.edit',
            compact(
                'costume',
                'categories'
            )
        );
    }
    public function update(
        UpdateCostumeRequest $request,
        Costume $costume
        )
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

            $data['image'] = $request
                ->file('image')
                ->store('costumes', 'public');
        }

        $costume->update($data);

        return redirect()
            ->route('admin.costumes.index')
            ->with(
                'success',
                'Cập nhật trang phục thành công'
            );
    }
    public function destroy(Costume $costume)
    {
        // Xóa ảnh nếu có
        if (
            $costume->image &&
            Storage::disk('public')->exists($costume->image)
        ) {
            Storage::disk('public')->delete($costume->image);
        }

        $costume->delete();

        return redirect()
            ->route('admin.costumes.index')
            ->with(
                'success',
                'Xóa trang phục thành công'
            );
    }
}
