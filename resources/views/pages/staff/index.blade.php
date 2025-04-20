@extends('layouts.master-layout', ['title' => 'Admin - Quản lý người dùng'])
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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Quản lý người dùng /</span> người dùng</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h4 class="card-title">Danh sách</h4>
                            @can('general-check', ['User Management', 'create'])
                            <a href="{{ route('staffs.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Thêm người dùng
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
                                        <th>Mã người dùng</th>
                                        <th>người dùng</th>
                                        <th>Vai trò</th>
                                        <th>Trạng thái</th>
                                        <th>Giới tính</th>
                                        <th>Ngày sinh</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                        
                                        function roleColor($name) {
                                            $color = 'bg-label-dark';
                                            switch ($name) {
                                                case 'Staff':
                                                    $color = 'bg-label-info';
                                                    break;
                                                case 'Manager':
                                                    $color = 'bg-label-warning';
                                                    break;
                                                case 'Customer':
                                                    $color = 'bg-label-danger';
                                                    break;
                                                case 'Supper Admin':
                                                    $color = 'bg-label-success';
                                                    break;
                                                default:
                                                    $color = 'bg-label-primary';
                                                    break;
                                            }

                                            return $color;
                                        }

                                    @endphp
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>
                                                <div>{{ $i++ }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="width: 120px">
                                                    <span class="badge bg-label-primary">{{ $item->staff->code }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="min-width: 250px">
                                                    <div class="d-block" style="width: 50px;"><img
                                                            class="rounded-circle object-fit-cover"
                                                            src="{{ $item->avatar }}" width="45px" height="45px"
                                                            alt=""></div>
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-item-center ms-2">
                                                        <b>{{ $item->name ?? 'N/A' }}</b>
                                                        <span>{{ '@' . $item->email }} </span>
                                                    </div>

                                                </div>
                                            </td>
                                            <td>
                                                <div style="min-width: 100px;"><span class="badge {{ roleColor($item->role->name) }}">{{ $item->role->name }}</span></div>
                                            </td>
                                            <td>
                                                <div style="min-width: 130px;" class="d-flex flex-column justify-content-center align-items-center">
                                                    <div
                                                        id="status-{{ $item->id }}"
                                                        class="badge {{ $item->is_active ? 'bg-label-success' : 'bg-label-danger' }}">
                                                        {{ $item->is_active ? 'Hoạt động' : 'Không hoạt động' }}</div>
                                                    <div class="toggler">
                                                        <input class="change-status" data-id="{{ $item->id }}" id="toggler-1" {{ $item->is_active ? 'checked' : '' }} name="toggler-1" type="checkbox"
                                                            value="1">
                                                        <label for="toggler-1">
                                                            <svg class="toggler-on" version="1.1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 130.2 130.2">
                                                                <polyline class="path check"
                                                                    points="100.2,40.2 51.5,88.8 29.8,67.5"></polyline>
                                                            </svg>
                                                            <svg class="toggler-off" version="1.1"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 130.2 130.2">
                                                                <line class="path line" x1="34.4" y1="34.4"
                                                                    x2="95.8" y2="95.8"></line>
                                                                <line class="path line" x1="95.8" y1="34.4"
                                                                    x2="34.4" y2="95.8"></line>
                                                            </svg>
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="width: 100px;">
                                                    <div
                                                    class="badge {{ $item->staff->gender == 'male' ? 'bg-label-info' : ($item->staff->gender == 'female' ? 'bg-label-warning' : 'bg-label-dark') }}">
                                                        {{ $item->staff->gender ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="width: 100px;"><span class="{{ $item->staff->dob ?? 'badge bg-label-dark' }}">{{ format_date($item->staff->dob) ?? 'N/A' }}</span></div>
                                            </td>
                                            <td>
                                                <div style="width: 100px;">{{ format_datetime($item->created_at) }}</div>
                                            </td>
                                            <td>
                                                <div style="width: 120px;">{{ format_datetime($item->updated_at) }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    @can('general-check', ['User Management', 'view'])
                                                    <a href="{{ route('staffs.edit', ['id' => $item->id]) }}"
                                                        type="button" data-bs-toggle="tooltip" title="Sửa"
                                                        class="btn btn-link text-primary" data-original-title="Edit Task">
                                                        <i class='bx bx-edit'></i>
                                                    </a>
                                                    @endcan
                                                    @can('general-check', ['User Management', 'update'])
                                                    <a href="{{ route('staffs.show', ['id' => $item->id]) }}"
                                                        type="button" data-bs-toggle="tooltip" title="Chi tiết"
                                                        class="btn btn-link text-warning" data-original-title="Edit Task">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
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
