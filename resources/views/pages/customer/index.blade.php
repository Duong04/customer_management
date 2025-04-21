@extends('layouts.master-layout', ['title' => 'Admin - Quản lý khách hàng'])
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .toggler {
            width: 72px;
            margin: 8px 0;
        }

        .toggler input {
            display: none;
        }

        .toggler label {
            display: block;
            position: relative;
            width: 60px;
            height: 28px;
            border: 1px solid #d6d6d6;
            border-radius: 36px;
            background: #e4e8e8;
            cursor: pointer;
        }

        .toggler label::after {
            display: block;
            border-radius: 100%;
            background-color: #d7062a;
            content: '';
            animation-name: toggler-size;
            animation-duration: 0.15s;
            animation-timing-function: ease-out;
            animation-direction: forwards;
            animation-iteration-count: 1;
            animation-play-state: running;
        }

        .toggler label::after,
        .toggler label .toggler-on,
        .toggler label .toggler-off {
            position: absolute;
            top: 50%;
            left: 25%;
            width: 26px;
            height: 26px;
            transform: translateY(-50%) translateX(-50%);
            transition: left 0.15s ease-in-out, background-color 0.2s ease-out, width 0.15s ease-in-out, height 0.15s ease-in-out, opacity 0.15s ease-in-out;
        }

        .toggler input:checked+label::after,
        .toggler input:checked+label .toggler-on,
        .toggler input:checked+label .toggler-off {
            left: 75%;
        }

        .toggler input:checked+label::after {
            background-color: #50ac5d;
            animation-name: toggler-size2;
        }

        .toggler .toggler-on,
        .toggler .toggler-off {
            opacity: 1;
            z-index: 2;
        }

        .toggler input:checked+label .toggler-off,
        .toggler input:not(:checked)+label .toggler-on {
            width: 0;
            height: 0;
            opacity: 0;
        }

        .toggler .path {
            fill: none;
            stroke: #fefefe;
            stroke-width: 7px;
            stroke-linecap: round;
            stroke-miterlimit: 10;
        }

        @keyframes toggler-size {

            0%,
            100% {
                width: 26px;
                height: 26px;
            }

            50% {
                width: 20px;
                height: 20px;
            }
        }

        @keyframes toggler-size2 {

            0%,
            100% {
                width: 26px;
                height: 26px;
            }

            50% {
                width: 20px;
                height: 20px;
            }
        }
    </style>
@endsection
@section('script')
    <script src="/assets/kai/js/plugin/datatables/datatables.min.js"></script>
    <script src="">
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});
        });
    </script>
    <script type="module" src="/assets/js/async.js"></script>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Quản lý người dùng /</span> Khách hàng</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h4 class="card-title">Danh sách</h4>
                            @can('general-check', ['Customer Management', 'create'])
                            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Thêm khách hàng
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Mã Khách hàng</th>
                                        <th>Tên đầy đủ</th>
                                        <th>Tên viết tắt</th>
                                        <th>Email</th>
                                        <th>Lĩnh vực</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
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
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>
                                                <div>{{ $i++ }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="min-width: 150px">
                                                    <span class="badge bg-label-primary">{{ $item->code }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="min-width: 150px">
                                                    {{ $item->company }}
                                                </div>
                                            </td>
                                            <td>
                                                <div style="width: 130px;">{{ $item->short_name }}</div>
                                            </td>
                                            <td>
                                                <div style="min-width: 10px;">{{ $item->customerContact->email }}</div>
                                            </td>
                                            <td>
                                                <div style="width: 100px;">{{ $item->industry }}</div>
                                            </td>
                                            <td>
                                                <div class="badge {{ $status_color[$item->status] }}"
                                                    style="min-width: 130px; font-size: 0.7rem;">
                                                    {{ $status[$item->status] }}</div>
                                            </td>
                                            <td>
                                                <div style="min-width: 140px;">{{ format_datetime($item->created_at) }}</div>
                                            </td>
                                            <td>
                                                <div style="min-width: 140px;">{{ format_datetime($item->updated_at) }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    @can('general-check', ['Customer Management', 'update'])
                                                    <a href="{{ route('customers.edit', ['id' => $item->id]) }}"
                                                        type="button" data-bs-toggle="tooltip" title="Sửa"
                                                        class="btn btn-link text-primary" data-original-title="Edit Task">
                                                        <i class='bx bx-edit'></i>
                                                    </a>
                                                    @endcan
                                                    @can('general-check', ['Customer Management', 'view'])
                                                    <a href="{{ route('customers.show', ['id' => $item->id]) }}"
                                                        type="button" data-bs-toggle="tooltip" title="Chi tiết"
                                                        class="btn btn-link text-warning" data-original-title="Edit Task">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    @endcan
                                                    @can('general-check', ['Customer Management', 'delete'])
                                                    <form class="d-flex align-items-center" id="delete-form-{{ $item->id }}" method="POST" action="{{ route('customers.delete', ['id' => $item->id]) }}">
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
                                                    @endcan
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
