<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Studio\StoreStudioRequest;
use App\Http\Requests\Admin\Studio\UpdateStudioRequest;
use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index(Request $request)
    {
        $data = Studio::query()

            ->when(
                $request->keyword,
                function ($query) use ($request) {

                    $query->where(
                        'name',
                        'like',
                        '%' . $request->keyword . '%'
                    )

                    ->orWhere(
                        'phone',
                        'like',
                        '%' . $request->keyword . '%'
                    );
                }
            )

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view(
            'admin.studios.index',
            compact('data')
        );
    }

    public function create()
    {
        return view(
            'admin.studios.create'
        );
    }

    public function store(
        StoreStudioRequest $request
    )
    {
        $data = $request->validated();

        $data['status'] =
            $request->has('status');

        Studio::create($data);

        return redirect()

            ->route(
                'admin.studios.index'
            )

            ->with(
                'success',
                'Thêm studio thành công'
            );
    }

    public function edit(
        Studio $studio
    )
    {
        return view(
            'admin.studios.edit',
            compact('studio')
        );
    }

    public function update(
        UpdateStudioRequest $request,
        Studio $studio
    )
    {
        $data = $request->validated();

        $data['status'] =
            $request->has('status');

        $studio->update($data);

        return redirect()

            ->route(
                'admin.studios.index'
            )

            ->with(
                'success',
                'Cập nhật studio thành công'
            );
    }

    public function destroy(
        Studio $studio
    )
    {
        $studio->delete();

        return redirect()

            ->route(
                'admin.studios.index'
            )

            ->with(
                'success',
                'Xóa studio thành công'
            );
    }
}