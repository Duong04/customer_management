@extends('layouts.master-layout', ['title' => 'Admin - Chi tiết hợp đồng'])
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    @php
        $status = [
            'valid' => 'Đang có hiệu lực',
            'expired' => 'Hết hạn',
            'not_yet_valid' => 'Chưa có hiệu lực',
        ];

        $status_color = [
            'valid' => 'bg-label-primary',
            'expired' => 'bg-label-danger',
            'not_yet_valid' => 'bg-label-secondary',
        ];
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-1"><span class="text-muted fw-light"><a href="{{ route('contracts.index') }}"><i class='bx bx-left-arrow-alt fs-3'></i></a> Chi tiết hợp đồng /</span></h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="row justify-content-between align-items-center">
                <div class="col-4">
                    Mã hợp đồng: <span class="badge bg-label-primary">{{ $contract->code }}</span>
                </div>
                <div class="col-8 d-flex justify-content-end align-items-start mb-3" style="gap: 10px;">
                    <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-outline-primary">✏️ Chỉnh sửa</a>
                    <form action="{{ route('contracts.delete', $contract->id) }}" id="delete-form-{{ $contract->id }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger delete">🗑️ Xóa</button>
                    </form>
                </div>
            </div>

            <div class="row">
                {{-- Thông tin hợp đồng --}}
                <div class="col-md-8">
                    <ul class="nav nav-tabs mb-3" id="contractTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                                type="button" role="tab" aria-controls="info" aria-selected="true">
                                <i class="fas fa-file-contract me-1"></i>Thông tin hợp đồng
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="histories-tab" data-bs-toggle="tab" data-bs-target="#histories"
                                type="button" role="tab" aria-controls="histories" aria-selected="false">
                                <i class="fas fa-history me-1"></i>Lịch sử
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" style="padding: 0;" id="contractTabContent">
                        {{-- Tab: Thông tin hợp đồng --}}
                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <div class="border rounded p-4 bg-white shadow-sm">
                                <h5 class="mb-4 text-primary">
                                    <i class="fas fa-file-contract me-2"></i>Thông tin hợp đồng
                                </h5>

                                {{-- Người lập & Người ký --}}
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label mb-0">Người lập hợp đồng</label>
                                        <div class="fw-semibold">{{ $contract->createdBy->name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label mb-0">Người ký hợp đồng</label>
                                        <div class="fw-semibold">{{ $contract->signer }}</div>
                                    </div>
                                </div>

                                {{-- Khách hàng & đại diện --}}
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label mb-0">Khách hàng</label>
                                        <div class="fw-semibold">{{ $contract->customer->company ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label mb-0">Đại diện khách hàng</label>
                                        <div class="fw-semibold">{{ $contract->customer_representative ?? 'N/A' }}</div>
                                    </div>
                                </div>

                                {{-- Giá trị & trạng thái --}}
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label mb-0">Giá trị hợp đồng</label>
                                        <div class="fw-semibold text-danger">
                                            {{ number_format($contract->contract_value, 0, ',', '.') }} ₫</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label mb-0">Trạng thái</label>
                                        <div class="fw-semibold">
                                            <span
                                                class="badge {{ $status_color[$contract->status] }}">{{ $status[$contract->status] ?? 'Không rõ' }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Thời gian --}}
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label mb-0">Ngày ký</label>
                                        <div class="fw-semibold">{{ format_date($contract->sign_date) }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mb-0">Ngày bắt đầu</label>
                                        <div class="fw-semibold">{{ format_date($contract->start_date) }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mb-0">Ngày kết thúc</label>
                                        <div class="fw-semibold">{{ format_date($contract->end_date) }}</div>
                                    </div>
                                </div>

                                {{-- Ghi chú --}}
                                <div class="mb-4">
                                    <label class="form-label mb-0">Ghi chú</label>
                                    <div class="fw-normal">{{ $contract->note ?? 'Không có ghi chú.' }}</div>
                                </div>

                                {{-- Tệp đính kèm --}}
                                <div>
                                    <label class="form-label mb-2">📎 Tệp đính kèm</label>
                                    <div class="row">
                                        @forelse ($contract->attachments as $file)
                                            <div class="col-md-4 mb-2">
                                                <div
                                                    class="border rounded px-2 py-3 bg-light d-flex justify-content-between align-items-center">
                                                    <a href="{{ $file->file_path }}" target="_blank" title="Xem tệp"
                                                        class="text-decoration-none text-truncate"
                                                        style="max-width: 140px;">
                                                        {{ basename($file->file_path) }}
                                                    </a>
                                                    <a href="{{ $file->file_path }}" download
                                                        class="btn btn-sm btn-outline-primary ms-2">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted">Không có tệp đính kèm.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab: Histories --}}
                        <div class="tab-pane fade" id="histories" role="tabpanel" aria-labelledby="histories-tab">
                            <div class="border rounded p-4 bg-white shadow-sm">
                                <h5 class="mb-4 text-primary">
                                    <i class="fas fa-history me-2"></i>Lịch sử thay đổi
                                </h5>

                                <div>
                                    @forelse ($contract->contractHistories as $history)
                                        <div class="border rounded p-3 mb-3 bg-light">
                                            <p class="mb-1"><strong>📝 Hành động:</strong> {{ $history->action }}</p>
                                            <p class="mb-1"><strong>Người thay đổi:</strong>
                                                {{ $history->changedBy->name ?? 'Không xác định' }}</p>
                                            <p class="mb-1"><strong>Ghi chú:</strong>
                                                {{ $history->note ?? 'Không có ghi chú' }}</p>
                                            <p class="text-muted small mb-0"><i class="fas fa-clock me-1"></i>
                                                {{ $history->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    @empty
                                        <p class="text-muted">Chưa có lịch sử thay đổi nào.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tiến độ thanh toán --}}
                <div class="col-md-4">
                    <div class="border rounded p-4 bg-white shadow-sm">
                        <h5 class="mb-4 text-primary">
                            <i class="fas fa-wallet me-2"></i>Tiến độ thanh toán
                        </h5>
                        @php
                            $payment_methods = [
                                'cash' => 'Tiền mặt',
                                'bank_transfer' => 'Chuyển khoản',
                                'credit_card' => 'Thẻ tín dụng',
                            ];
                        @endphp

                        @forelse ($contract->contractPayments as $payment)
                            <div class="mb-4 p-3 rounded bg-light border">
                                <h6 class="mb-2 text-success">💸 Đợt {{ $loop->iteration }}</h6>
                                <ul class="list-unstyled mb-0 small">
                                    <li><strong>Phương thức:</strong>
                                        {{ $payment_methods[$payment->payment_method] ?? 'Không có' }}</li>
                                    @if ($payment->payment_method == 'bank_transfer')
                                        <li><strong>Ngân hàng:</strong> {{ $payment->bank_name ?? 'Không có' }}</li>
                                        <li><strong>Số tài khoản:</strong> {{ $payment->account_number ?? 'Không có' }}
                                        </li>
                                        <li><strong>Chủ tài khoản:</strong> {{ $payment->account_holder ?? 'Không có' }}
                                        </li>
                                    @endif
                                    <li><strong>Số tiền:</strong> <span
                                            class="text-danger">{{ number_format($payment->amount, 0, ',', '.') }}
                                            ₫</span>
                                    </li>
                                    <li><strong>Ngày thanh toán:</strong> {{ format_date($payment->payment_date) }}</li>
                                    <li><strong>Trạng thái:</strong>
                                        <span
                                            class="badge {{ $payment->status == 'completed' ? 'bg-label-success' : 'bg-label-warning' }}">
                                            {{ $payment->status == 'completed' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                        </span>
                                    </li>
                                    <li><strong>Ghi chú:</strong> {{ $payment->note ?? 'Không có' }}</li>
                                </ul>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Chưa có đợt thanh toán nào.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
