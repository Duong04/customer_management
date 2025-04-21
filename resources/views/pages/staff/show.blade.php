@extends('layouts.master-layout', ['title' => 'Admin - Thông tin người dùng'])
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .rp-task {
    width: 150px;
}

.box-purple {
    background-color: rgb(222, 206, 255);
    color: rgb(140, 87, 255);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}
.nav-tabs {
        border-bottom: 2px solid #3fbbc0;
    }

    .nav-tabs .tab-custom {
        background-color: #f8f9fa;
        border: 1px solid #3fbbc0;
        border-bottom: none;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        padding: 10px 20px;
        color: #3fbbc0;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tabs .tab-custom:hover {
        background-color: #e0f7f9;
        color: #31999c;
    }

    .nav-tabs .tab-custom.active {
        background-color: #3fbbc0;
        color: #ffffff;
        font-weight: 600;
        border-color: #3fbbc0;
    }

</style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light d-flex align-items-center"><a href="{{ route('staffs.index') }}"><i class='bx bx-left-arrow-alt' style="font-size: 2.0rem;"></i></a> Thông tin người dùng</span></h4>
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="col-4 py-5 bg-white aside-shadow">
                    <div class="text-center">
                        <div class="img-avatar mx-auto">
                            <img width="120px" height="120px" class="rounded-circle object-fit-cover" src="{{ $user->avatar }}" alt="">
                        </div>
                        <h5 class="fs-5 mt-3">{{ $user->name }}</h5>
                        <span class="badge bg-label-primary">{{ $user->staff->code }}</span>
                    </div>
                    <div class="rp-task mx-auto d-flex flex-column mt-4" style="gap: 10px;">
                        <div class="d-flex g-10 align-items-center" style="gap: 10px;">
                            <div class="btn {{ $user->is_active ? 'bg-label-success' : 'bg-label-danger' }}">
                                <i class='bx bx-ghost' ></i>
                            </div>
                            <div class="d-flex flex-column">
                                <span>Trạng thái</span>
                                <span>{{ $user->is_active ? 'Hoạt động' : 'không hoạt động' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 10px;">
                            <div class="btn bg-label-warning">
                                <i class='bx bxs-group'></i>
                            </div>
                            <div class="d-flex flex-column">
                                <span>Vai trò</span>
                                <span>{{ $user->role->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="px-3 mt-3">
                        <h6 class="py-0">Chi tiết</h6>
                        <hr>
                        <ul class="nav d-flex flex-column" style="gap: 10px">
                            <li class="fs-7">
                                <span class="fw-semibold">Email:</span>
                                <span class="text-midgray">{{ $user->email ?? 'N/A' }}</span>
                            </li>
                            <li class="fs-7">
                                <span class="fw-semibold">Ngày sinh:</span>
                                <span class="text-midgray">{{ format_date($user->staff->dob) ?? 'N/A' }}</span>
                            </li>
                            <li class="fs-7">
                                <span class="fw-semibold">Ngày vào:</span>
                                <span class="text-midgray">{{ format_date($user->staff->join_date) ?? 'N/A' }}</span>
                            </li>
                            <li class="fs-7">
                                <span class="fw-semibold">Giới tính:</span>
                                <span class="text-midgray">{{ $user->staff->gender == 'male' ? 'Nam' : 'Nữ' }}</span>
                            </li>
                            <li class="fs-7">
                                <span class="fw-semibold">Số điện thoại:</span>
                                <span class="text-midgray">{{ $user->staff->phone ?? 'N/A' }}</span>
                            </li>
                            <li class="fs-7">
                                <span class="fw-semibold">Địa chỉ:</span>
                                <span class="text-midgray">{{ $user->staff->address ?? 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-8 bg-white p-3">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-custom active" id="thongtin-tab" data-bs-toggle="tab" data-bs-target="#thongtin" type="button" role="tab" aria-controls="thongtin" aria-selected="true">
                                Thông tin
                            </button>
                        </li>
                    </ul>
                
                    <!-- Tab content -->
                    <div class="tab-content pt-3 mt-2" id="myTabContent">
                        <div class="tab-pane fade show active" id="thongtin" role="tabpanel" aria-labelledby="thongtin-tab">
                            <form class="row" action="{{ route('staffs.update', ['id' => $user->id, 'redirect' => 'back']) }}" method="POST">
                                @csrf
                                @method('PUT')
                              
                                {{-- Họ và tên --}}
                                <div class="col-md-6 mb-3">
                                  <label class="form-label" for="name">Họ và tên</label>
                                  <input value="{{ $user->name }}" name="name" type="text" class="form-control" id="name" placeholder="Họ và tên" />
                                  @if ($errors->first('name'))
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('name') }}</span>
                                  @endif
                                </div>
                              
                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                  <label class="form-label" for="email">Email</label>
                                  <input value="{{ $user->email }}" name="email" type="text" class="form-control" id="email" placeholder="example@gmail.com" />
                                  @if ($errors->first('email'))
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('email') }}</span>
                                  @endif
                                </div>
                              
                                <div class="col-md-6 mb-3">
                                  <label class="form-label" for="phone">Số điện thoại</label>
                                  <input value="{{ $user->staff->phone }}" name="staff[phone]" type="text" class="form-control" id="phone" placeholder="Số điện thoại" />
                                  @if ($errors->first('staff.phone'))
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.phone') }}</span>
                                  @endif
                                </div>
                              
                                {{-- Trạng thái --}}
                                <div class="col-md-6 mb-3">
                                  <label class="form-label" for="gender">Giới tính</label>
                                  <select name="staff[gender]" class="form-control" id="gender">
                                    <option value="">-- Giới tính --</option>
                                    <option {{ $user->staff->gender == 'male' ? 'selected' : '' }} value="male">Nam</option>
                                    <option {{ $user->staff->gender == 'female' ? 'selected' : '' }} value="female">Nữ</option>
                                  </select>
                                  @if ($errors->first('staff.gender'))
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.gender') }}</span>
                                  @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                  <label class="form-label" for="is_active">Trạng thái tài khoản</label>
                                  <select name="is_active" class="form-control" id="is_active">
                                    <option value="">-- Trạng thái tài khoản --</option>
                                    <option {{ $user->is_active == 1 ? 'selected' : '' }} value="1">Hoạt động</option>
                                    <option {{ $user->is_active == 0 ? 'selected' : '' }} value="0">Không hoạt động</option>
                                  </select>
                                  @if ($errors->first('is_active'))
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('is_active') }}</span>
                                  @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                  <label class="form-label" for="join_date">Ngày vào</label>
                                  <input value="{{ $user->staff->join_date }}" name="staff[join_date]" type="date" class="form-control" id="join_date" />
                                  @if ($errors->first('staff.join_date'))
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.join_date') }}</span>
                                  @endif
                                </div>
            
                                <div class="col-md-6 mb-3">
                                  <label class="form-label" for="dob">Ngày sinh</label>
                                  <input value="{{ $user->staff->dob }}" name="staff[dob]" type="date" class="form-control" id="dob" />
                                  @if ($errors->first('staff.dob'))
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.dob') }}</span>
                                  @endif
                                </div>
                              
                                {{-- Địa chỉ --}}
                                <div class="col-md-6 mb-3">
                                  <label class="form-label" for="address">Địa chỉ</label>
                                  <input name="staff[address]" rows="4" type="text" class="form-control" id="address" placeholder="Địa chỉ" type="text" value="{{ $user->staff->address }}">
                                  @if ($errors->first('staff.address'))
                                    <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.address') }}</span>
                                  @endif
                                </div>
                              
                                <div class="col-12">
                                  <button type="submit" class="btn btn-primary">Lưu</button>
                                  <a href="{{ route('staffs.index') }}" class="btn btn-outline-danger">Hủy</a>
                                </div>
                              </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
