@extends('layouts.master-layout', ['title' => 'Admin - Hành động'])
@section('script')
<script src="/assets/kai/js/plugin/datatables/datatables.min.js"></script>
<script src="">
    $(document).ready(function () {
        $("#basic-datatables").DataTable({});
    });
</script>
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
                            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Thêm khách hàng
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Tên</th>
                                        <th>Mô tả</th>
                                        <th>Người dùng</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($roles as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                @if ($item->users_count > 0) 
                                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                    @foreach ($item->users as $item)
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="{{ $item->name }}">
                                                      <img src="{{ $item->avatar }}" alt="Avatar" class="rounded-circle">
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <a href="{{ route('roles.show', ['id' => $item->id]) }}" type="button" data-bs-toggle="tooltip" title="Sửa" class="btn btn-link text-primary" data-original-title="Edit Task">
                                                        <i class='bx bx-edit'></i>
                                                    </a>
                                                    <form class="d-flex align-items-center" id="delete-form-{{ $item->id }}" method="POST" action="{{ route('roles.delete', ['id' => $item->id]) }}">
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
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
