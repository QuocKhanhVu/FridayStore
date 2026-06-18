@extends('admin.layouts.master')

@section('title','Danh sách học sinh')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            Danh sách học sinh

        </h3>

        <p class="text-muted mb-0">

            {{ $rental->school_name }}
            -
            {{ $rental->class_name }}

        </p>

    </div>

    <form
        action="{{ route(
            'admin.rentals.students.auto-size',
            $rental->id
        ) }}"
        method="POST"
    >
        @csrf

        <button
            class="btn btn-success"
        >
            Chia size tự động
        </button>

    </form>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <table
            class="table table-hover align-middle mb-0"
        >

            <thead class="table-light">

                <tr>

                    <th width="70">
                        STT
                    </th>

                    <th>
                        Họ tên
                    </th>

                    <th>
                        Giới tính
                    </th>

                    <th>
                        Chiều cao
                    </th>

                    <th>
                        Cân nặng
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($students as $student)

                    <tr>

                        <td>
                            {{ $students->firstItem() + $loop->index }}
                        </td>

                        <td>

                            <strong>

                                {{ $student->full_name }}

                            </strong>

                        </td>

                        <td>

                            @if($student->gender == 'male')

                                Nam

                            @elseif($student->gender == 'female')

                                Nữ

                            @endif

                        </td>

                        <td>

                            {{ $student->height }}

                            cm

                        </td>

                        <td>

                            {{ $student->weight }}

                            kg

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="text-center py-4"
                        >

                            Chưa có dữ liệu

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer">

        {{ $students->links() }}

    </div>

</div>

@endsection