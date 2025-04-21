@extends('layouts.master-layout', ['title' => 'Admin - Chi tiết khách hàng'])
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    @php
        $status = [
            'information_exchange' => 'Trao đổi thông tin',
            'consulting_survey' => 'Khảo sát tư vấn',
            'quotation' => 'Báo giá',
            'negotiation' => 'Đàm phán',
            'contract_signed' => 'Ký hợp đồng',
            'payment_completed' => 'Thanh toán nghiệm thu',
            'no_contract_signed' => 'Không ký hợp đồng',
        ];

        $status_color = [
            'information_exchange' => 'bg-label-primary',
            'consulting_survey' => 'bg-label-info',
            'quotation' => 'bg-label-warning',
            'negotiation' => 'bg-label-secondary',
            'contract_signed' => 'bg-label-success',
            'payment_completed' => 'bg-label-dark',
            'no_contract_signed' => 'bg-label-danger',
        ];
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold pt-3 mb-1"><span class="text-muted fw-light"><a href="{{ route('contracts.index') }}"><i class='bx bx-left-arrow-alt fs-3'></i></a> Chi tiết khách hàng </span></h4>
        <div class="row">
            <div class="row justify-content-between align-items-center">
                <div class="col-4">
                    Mã khách hàng: <span class="badge bg-label-primary">{{ $customer->code }}</span>
                </div>
                <div class="col-8 d-flex justify-content-end align-items-start mb-3" style="gap: 10px;">
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-outline-primary">✏️ Chỉnh sửa</a>
                    <form action="{{ route('customers.delete', $customer->id) }}" id="delete-form-{{ $customer->id }}"
                        method="POST" class="d-inline" id="delete-form-{{ $customer->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger delete" data-id="{{ $customer->id }}">🗑️ Xóa</button>
                    </form>
                </div>
            </div>
            <div>
                <div class="row g-4">
                    {{-- Left column --}}
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body">
                                {{-- Thông tin công ty --}}
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <small class="text-muted">Tên đầy đủ</small>
                                        <div class="fw-semibold">{{ $customer->company }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Tên viết tắt</small>
                                        <div class="fw-semibold">{{ $customer->short_name }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Lĩnh vực</small>
                                        <div class="fw-semibold">{{ $customer->industry }}</div>
                                    </div>
                                </div>
        
                                {{-- Địa chỉ --}}
                                <div class="row">
                                    <div class="mb-3">
                                        <small class="text-muted">Địa chỉ cụ thể</small>
                                        <div class="fw-semibold">
                                            {{ $customer->address }}
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 col-4">
                                        <small class="text-muted">Phường/Xã</small>
                                        <div class="fw-semibold">
                                            {{ $wardName }}
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 col-4">
                                        <small class="text-muted">Quận/Huyện</small>
                                        <div class="fw-semibold">
                                            {{ $districtName }}
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 col-4">
                                        <small class="text-muted">Tỉnh/Thành phố</small>
                                        <div class="fw-semibold">
                                            {{ $provinceName }}
                                        </div>
                                    </div>
                                </div>
                                
        
                                {{-- Ghi chú --}}
                                <div class="mb-3 col-4">
                                    <small class="text-muted">Ghi chú</small>
                                    <div class="fw-normal">{{ $customer->note ?? 'Không có' }}</div>
                                </div>
        
                                {{-- Tệp đính kèm --}}
                                @if ($customer->file)
                                    <div class="mb-3">
                                        <small class="text-muted">Tệp đính kèm</small>
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $customer->file) }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                📎 Tải xuống
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
        
                        {{-- Thông tin người liên hệ --}}
                        @if ($customer->customerContact)
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body">
                                    <h6 class="mb-3">Người liên hệ</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <small class="text-muted">Họ tên</small>
                                            <div class="fw-semibold">{{ $customer->customerContact->name }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">Chức vụ</small>
                                            <div class="fw-semibold">{{ $customer->customerContact->position }}</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <small class="text-muted">Số điện thoại</small>
                                            <div class="fw-semibold">{{ $customer->customerContact->phone }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">Email</small>
                                            <div class="fw-semibold">{{ $customer->customerContact->email }}</div>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted">Giới tính</small>
                                        <div class="fw-semibold">
                                            {{ $customer->customerContact->gender === 'male' ? 'Nam' : ($customer->customerContact->gender === 'female' ? 'Nữ' : 'Khác') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- Right column --}}
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                    
                                <div class="mb-3">
                                    <small class="text-muted">Trạng thái</small>
                                    <div id="status-display" class="d-flex align-items-center justify-content-between">
                                        <span class="badge {{ $status_color[$customer->status] }}">{{ $status[$customer->status] }}</span>
                                        <button class="btn btn-sm btn-link p-0 text-primary" onclick="toggleEdit(true)">
                                            <i class="fas fa-edit me-1"></i> Sửa
                                        </button>
                                    </div>
                    
                                    {{-- Form chỉnh sửa trạng thái --}}
                                    <form method="POST" action="{{ route('customers.update', ['id' => $customer->id, 'redirect' => 'back']) }}"
                                          id="status-form" class="d-none mt-2">
                                        @csrf
                                        @method('PUT')
                    
                                        <div class="d-flex align-items-center gap-2">
                                            <select name="status" class="form-select form-select-sm" style="width: auto">
                                                @foreach ($status as $key => $label)
                                                    <option value="{{ $key }}" {{ $customer->status === $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                    
                                            <button type="submit" class="btn btn-sm btn-success">Lưu</button>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="toggleEdit(false)">Hủy</button>
                                        </div>
                                    </form>
                                </div>
                    
                                <div class="mb-3">
                                    <small class="text-muted">Ngày tạo</small>
                                    <div class="fw-semibold">{{ $customer->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                    
                                <div>
                                    <small class="text-muted">Ngày cập nhật</small>
                                    <div class="fw-semibold">{{ $customer->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
        
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    function toggleEdit(show) {
        const form = document.getElementById('status-form');
        const display = document.getElementById('status-display');

        if (show) {
            form.classList.remove('d-none');
            display.classList.add('d-none');
        } else {
            form.classList.add('d-none');
            display.classList.remove('d-none');
        }
    }
</script>
@endsection
