<?php

namespace App\Http\Controllers\Admin\costumes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Size\StoreSizeRequest;
use App\Models\Costume;
use App\Models\CostumeSize;
use App\Models\SizeRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
class sizesController extends Controller
{

public function index(Request $request)
{
    $data = CostumeSize::with(['costume', 'rule'])
    ->when($request->keyword, function ($query) use ($request) {
        $query->whereHas('costume', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%');
        });
    })
    ->orderBy('costume_id')
    ->orderBy('display_order')
    ->paginate(20);
   

    return view(
        'admin.warehouse.sizes.index',
        compact('data')
    );
}
    public function create()
    {
        $costumes = Costume::orderBy('name')->get();

        return view(
            'admin.warehouse.sizes.create',
            compact('costumes')
        );
    }


    public function store(StoreSizeRequest $request)
    {
        DB::transaction(function () use ($request) {

            foreach ($request->sizes as $index => $item) {

                $exists = CostumeSize::where(
                    'costume_id',
                    $request->costume_id
                )
                ->where(
                    'size_name',
                    $item['size_name']
                )
                ->exists();

                if ($exists) {

                    throw ValidationException::withMessages([

                        'sizes' => "Size {$item['size_name']} đã tồn tại"

                    ]);
                }

                $size = CostumeSize::create([

                    'costume_id' => $request->costume_id,

                    'size_name' => $item['size_name'],

                    'display_order' => $index + 1,

                    'status' => 1,

                ]);

                SizeRule::create([

                    'costume_size_id' => $size->id,

                    'height_from' => $item['height_from'],

                    'height_to' => $item['height_to'],

                    'weight_from' => $item['weight_from'],

                    'weight_to' => $item['weight_to'],

                ]);
            }

        });

        return redirect()
            ->route('admin.sizes.index')
            ->with(
                'success',
                'Thêm size thành công'
            );
    }
    public function edit(CostumeSize $costumeSize)
    {
        $costumes = Costume::orderBy('name')->get();

        $costumeSize->load([
            'costume.sizes.rule'
        ]);

        return view(
            'admin.warehouse.sizes.edit',
            compact(
                'costumeSize',
                'costumes'
            )
        );
    }

    public function update(
        StoreSizeRequest $request,
        CostumeSize $costumeSize
    )
    {
        DB::transaction(function () use (
            $request,
            $costumeSize
        ) {

            foreach ($request->sizes as $index => $item) {

                if (!empty($item['id'])) {

                    $size = CostumeSize::findOrFail(
                        $item['id']
                    );

                    $size->update([

                        'costume_id' => $request->costume_id,

                        'size_name' => $item['size_name'],

                        'display_order' => $index + 1,

                    ]);

                    $size->rule()->updateOrCreate(

                        [
                            'costume_size_id' => $size->id
                        ],

                        [
                            'height_from' =>
                                $item['height_from'] ?? null,

                            'height_to' =>
                                $item['height_to'] ?? null,

                            'weight_from' =>
                                $item['weight_from'] ?? null,

                            'weight_to' =>
                                $item['weight_to'] ?? null,
                        ]
                    );
                }
                else {

                    $size = CostumeSize::create([

                        'costume_id' =>
                            $request->costume_id,

                        'size_name' =>
                            $item['size_name'],

                        'display_order' =>
                            $index + 1,

                        'status' => 1,

                    ]);

                    SizeRule::create([

                        'costume_size_id' =>
                            $size->id,

                        'height_from' =>
                            $item['height_from'] ?? null,

                        'height_to' =>
                            $item['height_to'] ?? null,

                        'weight_from' =>
                            $item['weight_from'] ?? null,

                        'weight_to' =>
                            $item['weight_to'] ?? null,

                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.sizes.index')
            ->with(
                'success',
                'Cập nhật size thành công'
            );
    }

    public function destroy(CostumeSize $costumeSize)
    {
        DB::transaction(function () use (
            $costumeSize
        ) {

            $costumeSize->rule()->delete();

            $costumeSize->delete();

        });

        return redirect()
            ->route('admin.sizes.index')
            ->with(
                'success',
                'Xóa size thành công'
            );
    }


}
