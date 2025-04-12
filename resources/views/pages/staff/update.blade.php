@extends('layouts.master-layout', ['title' => 'Admin - Cập nhật nhân sự'])
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Quản lý người dùng /</span> Cập nhật nhân sự</h4>
        <!-- Hoverable Table rows -->
        <div class="row">
            <div class="col-xl">
              <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Thêm nhân sự</h5>
                  <a href="{{ route('staffs.index') }}"><small class="text-muted float-end d-flex align-item-center"><i class='bx bx-left-arrow-alt'></i> Quay về</small></a>
                </div>
                <div class="card-body">
                  <form class="row" action="{{ route('staffs.update', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                  
                    {{-- Họ và tên --}}
                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="name">Họ và tên</label>
                      <input value="{{ $user->name }}" name="name" type="text" class="form-control" id="name" placeholder="Họ và tên" />
                      @if ($errors->first('name'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  
                    {{-- Email --}}
                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="email">Email</label>
                      <input value="{{ $user->email }}" name="email" type="text" class="form-control" id="email" placeholder="example@gmail.com" />
                      @if ($errors->first('email'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  
                    {{-- Mật khẩu --}}
                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="password">Mật khẩu</label>
                      <input value="" name="password" type="password" class="form-control" id="password" placeholder="Mật khẩu" />
                      @if ($errors->first('password'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  
                    {{-- Tên viết tắt --}}
                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="role_id">Vai trò</label>
                      <select name="role_id" class="form-control" id="role_id">
                        <option value="">-- Vai trò --</option>
                        @foreach ($roles as $item)
                        <option {{ $user->role_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                      </select>
                      @if ($errors->first('role_id'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('role_id') }}</span>
                      @endif
                    </div>
                  
                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="phone">Số điện thoại</label>
                      <input value="{{ $user->staff->phone }}" name="staff[phone]" type="text" class="form-control" id="phone" placeholder="Số điện thoại" />
                      @if ($errors->first('staff.phone'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.phone') }}</span>
                      @endif
                    </div>
                  
                    {{-- Trạng thái --}}
                    <div class="col-md-4 mb-3">
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
                    <div class="col-md-4 mb-3">
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

                    @php
                        use Carbon\Carbon;
                    @endphp
                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="join_date">Ngày vào</label>
                      <input value="{{ $user->staff->join_date }}" name="staff[join_date]" type="date" class="form-control" id="join_date" />
                      @if ($errors->first('staff.join_date'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.join_date') }}</span>
                      @endif
                    </div>

                    <div class="col-md-4 mb-3">
                      <label class="form-label" for="dob">Ngày sinh</label>
                      <input value="{{ $user->staff->dob }}" name="staff[dob]" type="date" class="form-control" id="dob" />
                      @if ($errors->first('staff.dob'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.dob') }}</span>
                      @endif
                    </div>
                  
                    {{-- Địa chỉ --}}
                    <div class="col-md-6 mb-3">
                      <label class="form-label" for="address">Địa chỉ</label>
                      <textarea name="staff[address]" rows="4" type="text" class="form-control" id="address" placeholder="Địa chỉ">{{ $user->staff->address }}</textarea>
                      @if ($errors->first('staff.address'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.address') }}</span>
                      @endif
                    </div>
                    {{-- Mô tả --}}
                    <div class="col-md-6 mb-3">
                      <label class="form-label" for="note">Ghi chú</label>
                      <textarea name="staff[note]" rows="4" class="form-control" id="note" placeholder="Ghi chú">{{ $user->staff->note }}</textarea>
                      @if ($errors->first('staff.note'))
                        <span class="text-danger" style="font-size: 0.8rem;">{{ $errors->first('staff.note') }}</span>
                      @endif
                    </div>
                  
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                  </form>
                  
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection
