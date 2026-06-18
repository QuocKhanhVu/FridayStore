<?php

namespace App\Http\Controllers\Admin\Concept;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Concept\StoreConceptRequest;
use App\Http\Requests\Admin\Concept\UpdateConceptRequest;
use App\Models\Concept;
use App\Models\Costume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConceptController extends Controller
{
    public function index(Request $request)
    {
        $data = Concept::withCount('costumes')

            ->when(
                $request->keyword,
                function ($query) use ($request) {

                    $query->where(
                        'name',
                        'like',
                        '%' . $request->keyword . '%'
                    );

                }
            )

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view(
            'admin.concepts.index',
            compact('data')
        );
    }

    public function create()
    {
        $costumes = Costume::where(
            'status',
            1
        )->orderBy('name')->get();

        return view(
            'admin.concepts.create',
            compact('costumes')
        );
    }

    public function store(
        StoreConceptRequest $request
    )
    {
        $data = $request->validated();


        $data['slug'] = Str::slug(
            $data['name']
        );

        if ($request->hasFile('thumbnail')) {

            $data['thumbnail'] = $request
                ->file('thumbnail')
                ->store(
                    'concepts',
                    'public'
                );
        }

        $concept = Concept::create($data);

        if ($request->filled('costumes')) {

            $concept->costumes()
                ->sync(
                    $request->costumes
                );
        }

        return redirect()

            ->route(
                'admin.concepts.index'
            )

            ->with(
                'success',
                'Thêm concept thành công'
            );
    }

    public function edit(
        Concept $concept
    )
    {
        $costumes = Costume::where(
            'status',
            1
        )->orderBy('name')->get();

        $selectedCostumes = $concept
            ->costumes
            ->pluck('id')
            ->toArray();

        return view(
            'admin.concepts.edit',
            compact(
                'concept',
                'costumes',
                'selectedCostumes'
            )
        );
    }

    public function update(
        UpdateConceptRequest $request,
        Concept $concept
    )
    {
        $data = $request->validated();

        $data['slug'] = Str::slug(
            $data['name']
        );

        if ($request->hasFile('thumbnail')) {

            if (
                $concept->thumbnail &&
                Storage::disk('public')
                    ->exists(
                        $concept->thumbnail
                    )
            ) {

                Storage::disk('public')
                    ->delete(
                        $concept->thumbnail
                    );
            }

            $data['thumbnail'] = $request
                ->file('thumbnail')
                ->store(
                    'concepts',
                    'public'
                );
        }

        $concept->update($data);

        $concept->costumes()->sync(
            $request->costumes ?? []
        );

        return redirect()

            ->route(
                'admin.concepts.index'
            )

            ->with(
                'success',
                'Cập nhật concept thành công'
            );
    }

    public function destroy(
        Concept $concept
    )
    {
        if (
            $concept->thumbnail &&
            Storage::disk('public')
                ->exists(
                    $concept->thumbnail
                )
        ) {

            Storage::disk('public')
                ->delete(
                    $concept->thumbnail
                );
        }

        $concept->costumes()->detach();

        $concept->delete();

        return redirect()

            ->route(
                'admin.concepts.index'
            )

            ->with(
                'success',
                'Xóa concept thành công'
            );
    }
}