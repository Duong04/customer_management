@php
    use Carbon\Carbon;
@endphp
@extends('layouts.master-layout', ['title' => 'Admin - Tạo hợp đồng'])

@section('css')
    <style>
        .upload-box {
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 2px dashed #0b2dee;
            padding: 0 10px;
            min-height: 140px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: relative;
        }

        .upload-box:hover {
            background-color: #d6e5fc;
        }

        .upload-box i,
        .upload-box span {
            pointer-events: none;
        }

        .text-purple {
            color: #0b2dee;
        }

        .btn-plus,
        .btn-remove {
            cursor: pointer;
        }

        .btn-plus:hover,
        .btn-remove:hover {
            opacity: 0.8;
        }

        .bank-info-fields {
            animation: opacity 0.4s ease
        }

        @keyframes opacity {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Quản lý hợp đồng /</span> Tạo hợp đồng</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tạo hợp đồng</h5>
                        <a href="{{ route('contracts.index') }}"><small
                                class="text-muted float-end d-flex align-item-center"><i class='bx bx-left-arrow-alt'></i>
                                Quay về</small></a>
                    </div>
                    <div class="card-body">
                        <form class="row" action="{{ route('contracts.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Tên hợp đồng --}}
                            <div class="col-md-6">
                                <label class="form-label" for="name">Tên hợp đồng ( <span class="text-danger">*</span> )</label>
                                <input value="{{ old('name') }}" name="name" type="text" class="form-control"
                                    id="name" placeholder="Nhập tên hợp đồng" />
                                @error('name')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Khách hàng --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="customer_id">Khách hàng ( <span class="text-danger">*</span> )</label>
                                <select name="customer_id" class="form-control" id="customer_id">
                                    <option value="">-- Chọn khách hàng --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->company }} ({{ $customer->short_name }})</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="signer">Người ký ( <span class="text-danger">*</span> )</label>
                                <input value="{{ old('signer') }}" name="signer" type="text" class="form-control"
                                    id="signer" placeholder="Tên người ký" />
                                @error('signer')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Ngày bắt đầu --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="start_date">Ngày bắt đầu ( <span class="text-danger">*</span> )</label>
                                <input value="{{ old('start_date', Carbon::now()->format('Y-m-d')) }}" name="start_date"
                                    type="date" class="form-control" id="start_date" />
                                @error('start_date')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Ngày ký --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="sign_date">Ngày ký ( <span class="text-danger">*</span> )</label>
                                <input value="{{ old('sign_date', Carbon::now()->format('Y-m-d')) }}" name="sign_date"
                                    type="date" class="form-control" id="sign_date" />
                                @error('sign_date')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>


                            {{-- Trạng thái --}}
                            @php
                                $startDate = old('start_date', Carbon::now()->format('Y-m-d'));
                                $status = old('status');

                                if (!$status) {
                                    $status = Carbon::parse($startDate)->gt(Carbon::now()) ? 'not_yet_valid' : 'valid';
                                }
                            @endphp

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status">Trạng thái</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="">-- Trạng thái --</option>
                                    <option value="valid" {{ $status == 'valid' ? 'selected' : '' }}>Đang hiệu lực
                                    </option>
                                    <option value="expired" {{ $status == 'expired' ? 'selected' : '' }}>Hết hạn</option>
                                    <option value="not_yet_valid" {{ $status == 'not_yet_valid' ? 'selected' : '' }}>Chưa
                                        có
                                        hiệu lực</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="end_date">Ngày kết thúc</label>
                                <input value="{{ old('end_date') }}" name="end_date" type="date" class="form-control"
                                    id="end_date" />
                                @error('end_date')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="customer_representative">Đại diện khách hàng ( <span class="text-danger">*</span> )</label>
                                <input value="{{ old('customer_representative') }}" name="customer_representative" type="text"
                                    step="0.01" class="form-control" id="customer_representative" placeholder="Đại diện khách hàng" />
                                @error('customer_representative')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Giá trị hợp đồng --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="contract_value">Giá trị hợp đồng ( <span class="text-danger">*</span> )</label>
                                <input value="{{ old('contract_value') }}" name="contract_value" type="number"
                                    step="0.01" class="form-control" id="contract_value" placeholder="Nhập giá trị" />
                                @error('contract_value')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Phương thức thanh toán --}}
                            <div class="form-group mb-3">
                                <h6 class="mb-2">Thông tin thanh toán</h6>
                                <div id="emptyPaymentText" class="text-muted d-flex align-items-cnter"><span>Bạn chưa có
                                        thông tin thanh toán.</span> <button type="button"
                                        class="btn btn-sm text-primary" data-bs-toggle="tooltip" title="Tạo thanh toán"
                                        id="addPaymentBtn"><i class='bx bx-plus-circle'></i></button></div>

                                <div id="paymentContainer" style="display: none;">
                                    <!-- Danh sách các block form thanh toán sẽ được thêm ở đây -->
                                </div>

                                <button type="button" class="btn btn-sm text-primary d-none" id="addMorePaymentBtn"
                                    data-bs-toggle="tooltip" title="Tạo thanh toán" id="addPaymentBtn"><i
                                        class='bx bx-plus-circle'></i></button>
                            </div>

                            {{-- File đính kèm --}}
                            @php
                                $attachments = old('attachments', [['file' => null]]);
                            @endphp
                            <div class="form-group col-12">
                                <label>Tệp đính kèm</label>
                                <div id="attachment-wrapper" class="row">
                                    @foreach ($attachments as $index => $attachment)
                                        <div class="d-flex flex-column mb-2 attachment-item py-2 col-4"
                                            data-index="{{ $index }}">
                                            <div class="col-md-12 d-flex align-items-center mb-2">
                                                <div class="text-danger me-2 cursor-pointer btn-remove">
                                                    <i class='bx bx-trash'></i>
                                                </div>
                                                <div class="text-primary cursor-pointer btn-plus add-attachment">
                                                    <i class='bx bx-plus'></i>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="upload-box w-100 text-center">
                                                    <i style="font-size: 2.2rem;"
                                                        class='bx bx-cloud-upload fa-2x text-purple'></i>
                                                    <span class="text-purple">Upload File</span>
                                                    <small class="file-name text-muted text-truncate d-block mt-1"></small>
                                                    <input type="file" name="attachments[{{ $index }}][file]"
                                                        class="form-control upload-input" hidden />
                                                </label>
                                                @error("attachments.$index.file")
                                                    <span class="text-danger fs-7">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Ghi chú --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="note">Ghi chú</label>
                                <textarea name="note" rows="4" class="form-control" id="note" placeholder="Ghi chú">{{ old('note') }}</textarea>
                                @error('note')
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <a href="{{ route('contracts.index') }}" class="btn btn-outline-danger">Hủy</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const oldPayments = @json(old('payments', [])); // Dữ liệu cũ của các trường 'payments'
        const errors = @json($errors->get('payments.*')); // Lỗi validation

        document.addEventListener("DOMContentLoaded", function() {
            let wrapper = document.getElementById("attachment-wrapper");

            let index = wrapper.querySelectorAll(".attachment-item").length;

            function updateRemoveButtonsVisibility() {
                const items = wrapper.querySelectorAll(".attachment-item");
                const removeButtons = wrapper.querySelectorAll(".btn-remove");

                if (items.length === 1) {
                    removeButtons.forEach(btn => btn.style.display = "none");
                } else {
                    removeButtons.forEach(btn => btn.style.display = "");
                }
            }

            updateRemoveButtonsVisibility();

            wrapper.addEventListener("click", function(e) {
                if (e.target.closest(".add-attachment")) {
                    let newItem = document.createElement("div");
                    newItem.classList.add("d-flex", "flex-column", "mb-2", "attachment-item", "py-2",
                        "col-4");
                    newItem.setAttribute("data-index", index);

                    newItem.innerHTML = `
                    <div class="col-md-12 d-flex align-items-center mb-2">
                        <div class="text-danger me-2 cursor-pointer btn-remove">
                             <i class='bx bx-trash'></i>
                        </div>
                        <div class="text-primary cursor-pointer btn-plus add-attachment">
                            <i class="bx bx-plus"></i>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="upload-box w-100 text-center">
                            <i style="font-size: 2.2rem;" class='bx bx-cloud-upload fa-2x text-purple'></i>
                            <span class="text-purple">Upload File</span>
                            <small class="file-name text-muted text-truncate d-block mt-1"></small>
                            <input type="file" name="attachments[${index}][file]" class="form-control upload-input" hidden />
                        </label>
                    </div>
                `;

                    wrapper.appendChild(newItem);
                    index++;

                    updateRemoveButtonsVisibility(); // Gọi lại để kiểm tra số lượng item
                }
            });

            // Xoá file
            wrapper.addEventListener("click", function(e) {
                if (e.target.closest(".btn-remove")) {
                    let item = e.target.closest(".attachment-item");
                    if (item) {
                        item.remove();
                        updateRemoveButtonsVisibility(); // Gọi lại sau khi xoá
                    }
                }
            });

            // Hiển thị tên file khi chọn
            wrapper.addEventListener("change", function(e) {
                if (e.target.matches(".upload-input")) {
                    let fileInput = e.target;
                    let fileName = fileInput.files[0]?.name || '';
                    fileInput.closest("label").querySelector(".file-name").textContent = fileName;
                }
            });

            const startDateInput = document.getElementById('start_date');
            const statusSelect = document.getElementById('status');

            function updateStatusBasedOnDate() {
                const today = new Date().toISOString().split('T')[0];
                const selectedDate = startDateInput.value;

                if (!selectedDate) return;

                if (selectedDate > today) {
                    statusSelect.value = 'not_yet_valid';
                } else {
                    statusSelect.value = 'valid';
                }
            }

            // Gọi khi trang load
            updateStatusBasedOnDate();

            // Gọi lại khi người dùng đổi ngày
            startDateInput.addEventListener('change', updateStatusBasedOnDate);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const addPaymentBtn = document.getElementById('addPaymentBtn');
            const addMorePaymentBtn = document.getElementById('addMorePaymentBtn');
            const paymentContainer = document.getElementById('paymentContainer');

            const paymentTemplate = (data = {}, errors = {}, index = 0) => {
                const getError = (field) => errors?.[`payments.${index}.${field}`] ?
                    `<div style="font-size: 0.8rem;" class="text-danger mt-1">${errors[`payments.${index}.${field}`][0]}</div>` :
                    '';
                const value = (field) => data[field] || '';

                return `
                <div class="border rounded p-3 pt-4 mb-3 payment-item position-relative" data-index="${index}">
                    <button type="button" data-bs-toggle="tooltip" title="Xóa" class="m-2 btn text-danger btn-sm position-absolute top-0 end-0 remove-payment-btn">
                        <i class='bx bx-trash'></i>
                    </button>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Phương thức thanh toán ( <span class="text-danger">*</span> )</label>
                            <select name="payments[${index}][payment_method]" class="form-control payment-method-select">
                                <option value="">-- Chọn phương thức --</option>
                                <option value="cash" ${value('payment_method') === 'cash' ? 'selected' : ''}>Tiền mặt</option>
                                <option value="bank_transfer" ${value('payment_method') === 'bank_transfer' ? 'selected' : ''}>Chuyển khoản</option>
                                <option value="credit_card" ${value('payment_method') === 'credit_card' ? 'selected' : ''}>Thẻ tín dụng</option>
                            </select>
                            ${getError('payment_method')}
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Số tiền ( <span class="text-danger">*</span> )</label>
                            <input name="payments[${index}][amount]" type="number" step="0.01" class="form-control" value="${value('amount')}" placeholder="100000">
                            ${getError('amount')}
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Trạng thái ( <span class="text-danger">*</span> )</label>
                            <select name="payments[${index}][status]" class="form-control">
                                <option value="">-- Trạng thái --</option>
                                <option value="pending" ${value('status') === 'pending' ? 'selected' : ''}>Đang chờ</option>
                                <option value="completed" ${value('status') === 'completed' ? 'selected' : ''}>Đã thanh toán</option>
                            </select>
                            ${getError('status')}
                        </div>
                    </div>

                    ${value('payment_method') === 'bank_transfer' ? 
                        `<div class="form-group bank-info-fields">` :
                        `<div class="form-group bank-info-fields" style="display: none;">`
                    }
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tên ngân hàng ( <span class="text-danger">*</span> )</label>
                                    <input name="payments[${index}][bank_name]" type="text" class="form-control" value="${value('bank_name')}" placeholder="Ví dụ: Vietcombank" />
                                    ${getError('bank_name')}
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Số tài khoản ( <span class="text-danger">*</span> )</label>
                                    <input name="payments[${index}][account_number]" type="text" class="form-control" value="${value('account_number')}" placeholder="Nhập số tài khoản" />
                                    ${getError('account_number')}
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Chủ tài khoản ( <span class="text-danger">*</span> )</label>
                                    <input name="payments[${index}][account_holder]" type="text" class="form-control" value="${value('account_holder')}" placeholder="Tên chủ tài khoản" />
                                    ${getError('account_holder')}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            };


            let paymentIndex = 0;
            oldPayments.forEach((paymentData, index) => {
                paymentContainer.innerHTML += paymentTemplate(paymentData, errors, index);
                paymentIndex = index + 1;
            });

            if (oldPayments.length > 0) {
                const emptyText = document.getElementById('emptyPaymentText');
                if (emptyText) emptyText.remove();
                paymentContainer.style.display = 'block';
                addPaymentBtn.classList.add('d-none');
                addMorePaymentBtn.classList.remove('d-none');
            }

            function bindPaymentMethodChangeEvents() {
                document.querySelectorAll('.payment-method-select').forEach(select => {
                    select.removeEventListener('change', handleChange);
                    select.addEventListener('change', handleChange);
                });
            }

            function handleChange(event) {
                const paymentItem = event.target.closest('.payment-item');
                const selected = event.target.value;
                const bankFields = paymentItem.querySelector('.bank-info-fields');
                bankFields.style.display = selected === 'bank_transfer' ? 'flex' : 'none';
            }

            function bindRemoveButtonEvents() {
                document.querySelectorAll('.remove-payment-btn').forEach(btn => {
                    btn.removeEventListener('click', handleRemove);
                    btn.addEventListener('click', handleRemove);
                });
            }

            function handleRemove(event) {
                const paymentItem = event.target.closest('.payment-item');
                paymentItem.remove();

                if (document.querySelectorAll('.payment-item').length === 0) {
                    paymentContainer.style.display = 'none';
                    addPaymentBtn.classList.remove('d-none');
                    addMorePaymentBtn.classList.add('d-none');
                }
            }

            addPaymentBtn.addEventListener('click', () => {
                const emptyText = document.getElementById('emptyPaymentText');
                if (emptyText) emptyText.remove();

                document.querySelectorAll('.tooltip').forEach(el => el.remove());
                paymentContainer.style.display = 'block';
                const wrapper = document.createElement('div');
                wrapper.innerHTML = paymentTemplate({}, {}, paymentIndex++);
                paymentContainer.appendChild(wrapper.firstElementChild);
                bindPaymentMethodChangeEvents();
                bindRemoveButtonEvents();
                addMorePaymentBtn.classList.remove('d-none');
                addPaymentBtn.classList.add('d-none');
            });

            addMorePaymentBtn.addEventListener('click', () => {
                const wrapper = document.createElement('div');
                wrapper.innerHTML = paymentTemplate({}, {}, paymentIndex++);
                paymentContainer.appendChild(wrapper.firstElementChild);
                bindPaymentMethodChangeEvents();
                bindRemoveButtonEvents();
            });

            bindPaymentMethodChangeEvents();
            bindRemoveButtonEvents();
        });
    </script>
@endsection
