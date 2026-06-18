
<div class="modal fade" id="statusModal{{ $item->id }}" tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <form
                action="{{ route('admin.rental-management.status', $item->id) }}"
                method="POST"
            >

                @csrf
                @method('PATCH')

                <div class="modal-header bg-primary text-white">

                    <div>
                        <h5 class="mb-1 fw-bold">
                            Quản lý đơn thuê
                        </h5>

                        <small class="opacity-75">
                            Mã đơn: {{ $item->code }}
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div
                        class="card border-0 shadow-sm mb-4"
                        style="
                            background: linear-gradient(
                                135deg,
                                #f8fafc,
                                #eef2ff
                            );
                        "
                    >

                        <div class="card-body">

                            <div class="row align-items-center">

                                <div class="col-md-8">

                                    <h5 class="fw-bold mb-2">
                                        {{ $item->school_name ?? 'Chưa cập nhật trường' }}
                                    </h5>

                                    <div class="text-muted mb-2">
                                        Lớp:
                                        <strong>
                                            {{ $item->class_name ?? 'Chưa cập nhật lớp' }}
                                        </strong>
                                    </div>

                                    <div class="mb-2">
                                        👨‍🎓
                                        <strong>
                                            {{ $item->students_count }}
                                        </strong>
                                        học sinh
                                    </div>

                                    <div>
                                        📸
                                        Ngày chụp:
                                        <strong>
                                            {{ \Carbon\Carbon::parse($item->shooting_date)->format('d/m/Y') }}
                                        </strong>
                                    </div>

                                </div>

                                <div class="col-md-4 text-md-end mt-3 mt-md-0">

                                    <span
                                        class="
                                            badge
                                            px-4
                                            py-3
                                            rounded-pill
                                            fw-bold
                                            text-white
                                            shadow-sm

                                            @if($item->status=='renting')
                                                bg-warning text-dark
                                            @elseif($item->status=='processing')
                                                bg-danger
                                            @else
                                                bg-success
                                            @endif
                                        "
                                        style="
                                            font-size:14px;
                                            min-width:150px;
                                        "
                                    >

                                        @if($item->status=='renting')
                                            Đang thuê
                                        @elseif($item->status=='processing')
                                            Đang xử lý
                                        @else
                                            Hoàn thành
                                        @endif

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            Trạng thái đơn thuê
                        </label>

                        <select
                            name="status"
                            class="form-select form-select-lg status-select"
                        >

                            <option
                                value="renting"
                                {{ $item->status == 'renting' ? 'selected' : '' }}
                            >
                                Đang thuê
                            </option>

                            <option
                                value="processing"
                                {{ $item->status == 'processing' ? 'selected' : '' }}
                            >
                                Đang xử lý
                            </option>

                            <option
                                value="completed"
                                {{ $item->status == 'completed' ? 'selected' : '' }}
                            >
                                Hoàn thành
                            </option>

                        </select>

                    </div>

                    <div
                        class="processing-note"
                        style="{{ $item->status == 'processing' ? '' : 'display:none' }}"
                    >

                        <label
                            class="
                                form-label
                                fw-bold
                                text-danger
                            "
                        >
                            Lý do xử lý
                        </label>

                        <textarea
                            name="processing_note"
                            rows="5"
                            class="form-control shadow-sm"
                            placeholder="Nhập lý do xử lý..."
                        >{{ $item->processing_note }}</textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Đóng
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa fa-save me-2"></i>
                        Lưu thay đổi
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function(){

        document
            .querySelectorAll('.status-select')
            .forEach(function(select){

                select.addEventListener(
                    'change',
                    function(){

                        let noteBox =
                            this.closest('.modal-body')
                                .querySelector('.processing-note');

                        if(this.value === 'processing'){

                            noteBox.style.display = 'block';

                        }else{

                            noteBox.style.display = 'none';

                        }

                    }
                );

            });

    }
);

</script>
