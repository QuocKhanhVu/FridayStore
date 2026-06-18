<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Inventory\StoreInventoryRequest;
use App\Models\Costume;
use App\Models\Inventory;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CostumeCategory;
use App\Models\CostumeSize;
use App\Exports\InventoryExport;
use Maatwebsite\Excel\Facades\Excel;
class InventoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = CostumeCategory::orderBy('name')->get();

        $sizes = CostumeSize::orderBy('size_name')->get();

        $data = Inventory::with([
            'costume.category',
            'size'
        ])

        ->when($request->keyword, function ($query) use ($request) {

            $query->whereHas('costume', function ($q) use ($request) {

                $q->where(
                    'name',
                    'like',
                    '%' . $request->keyword . '%'
                );

            });

        })

        ->when($request->category_id, function ($query) use ($request) {

            $query->whereHas('costume', function ($q) use ($request) {

                $q->where(
                    'category_id',
                    $request->category_id
                );

            });

        })

        ->when($request->size_id, function ($query) use ($request) {

            $query->where(
                'costume_size_id',
                $request->size_id
            );

        })

        ->latest()

        ->paginate(20)

        ->withQueryString();

        return view(
            'admin.warehouse.inventory.index',
            compact(
                'data',
                'categories',
                'sizes'
            )
        );
    }

    public function create()
    {
        $costumes = Costume::with('sizes')
            ->where('status',1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.warehouse.inventory.create',
            compact('costumes')
        );
    }

    public function store(StoreInventoryRequest $request)
    {
        $inventory = Inventory::firstOrCreate(

            [

                'costume_id' => $request->costume_id,

                'costume_size_id' => $request->costume_size_id,

            ],

            [

                'quantity' => 0,

                'rented_quantity' => 0,

                'broken_quantity' => 0,

                'lost_quantity' => 0,

            ]

        );

        $inventory->increment(
            'quantity',
            $request->quantity
        );

        InventoryLog::create([

            'costume_id' => $request->costume_id,

            'costume_size_id' => $request->costume_size_id,

            'type' => 'import',

            'quantity' => $request->quantity,

            'note' => $request->note,

        ]);

        return redirect()
            ->route('admin.inventory.create')
            ->with(
                'success',
                'Nhập kho thành công'
            );
    }
    public function export()
    {
        return Excel::download(
            new InventoryExport(),
            'ton-kho.xlsx'
        );
    }
}