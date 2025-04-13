@extends('layouts.master-layout', ['title' => 'Admin - Quản lý hợp đồng'])
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Quản lý hợp đồng /</span> Hợp đồng</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h4 class="card-title">Danh sách</h4>
                            <a href="{{ route('contracts.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Tạo hợp đồng
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Mã hợp đồng</th>
                                        <th>Tên hợp đồng</th>
                                        <th>Khách hàng</th>
                                        <th>Người tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày ký</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                        
                                        $status = [
                                            'valid' => 'Đang có hiệu lực',
                                            'expired' => 'Hết hạn',
                                            'not_yet_valid' => 'Chưa có hiệu lực'
                                        ];

                                        $status_color = [
                                            'valid' => 'bg-label-primary',
                                            'expired' => 'bg-label-danger',
                                            'not_yet_valid' => 'bg-label-secondary'
                                        ];

                                    @endphp
                                    @foreach ($contracts as $item)
                                        <tr>
                                            <td>
                                                <div>{{ $i++ }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="width: 120px">
                                                    <span class="badge bg-label-primary">{{ $item->code }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="min-width: 160px;">{{ $item->name }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="min-width: 250px">
                                                    <div class="d-block" style="width: 50px;"><img
                                                            class="rounded-circle object-fit-cover"
                                                            src="{{ $item->customer->user->avatar }}" width="45px" height="45px"
                                                            alt=""></div>
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-item-center ms-2">
                                                        <b>{{ $item->customer->fullname ?? 'N/A' }}</b>
                                                        <span>{{ '@' . $item->customer->user->email }} </span>
                                                    </div>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="min-width: 250px">
                                                    <div class="d-block" style="width: 50px;"><img
                                                            class="rounded-circle object-fit-cover"
                                                            src="{{ $item->createdBy->avatar }}" width="45px" height="45px"
                                                            alt=""></div>
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-item-center ms-2">
                                                        <b>{{ $item->createdBy->name ?? 'N/A' }}</b>
                                                        <span>{{ '@' . $item->createdBy->email }} </span>
                                                    </div>

                                                </div>
                                            </td>
                                            <td>
                                                <div style="min-width: 100px;">
                                                    <div
                                                    class="badge {{ $status_color[$item->status] }}">
                                                        {{ $status[$item->status] ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="min-width: 100px;"><span class="{{ $item->sign_date ?? 'badge bg-label-dark' }}">{{ $item->sign_date ?? 'N/A' }}</span></div>
                                            </td>
                                            <td>
                                                <div style="min-width: 130px;"><span class="{{ $item->start_date ?? 'badge bg-label-dark' }}">{{ $item->start_date ?? 'N/A' }}</span></div>
                                            </td>
                                            <td>
                                                <div style="min-width: 130px;"><span class="{{ $item->end_date ?? 'badge bg-label-dark' }}">{{ $item->end_date ?? 'N/A' }}</span></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <a href="{{ route('contracts.show', ['id' => $item->id]) }}"
                                                        type="button" data-bs-toggle="tooltip" title="Sửa"
                                                        class="btn btn-link text-primary" data-original-title="Edit Task">
                                                        <i class='bx bx-edit'></i>
                                                    </a>
                                                    <a href="{{ route('staffs.show', ['id' => $item->id]) }}"
                                                        type="button" data-bs-toggle="tooltip" title="Chi tiết"
                                                        class="btn btn-link text-warning" data-original-title="Edit Task">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <form class="d-flex align-items-center" id="delete-form-{{ $item->id }}" method="POST" action="{{ route('contracts.delete', ['id' => $item->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                          data-bs-toggle="tooltip"
                                                          title="Xóa"
                                                          class="btn btn-link text-danger delete"
                                                          data-original-title="Remove"
                                                          data-id="{{ $item->id }}"
                                                        >
                                                            <i class='bx bx-trash' ></i>
                                                        </button>
                                                      </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection